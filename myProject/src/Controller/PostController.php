<?php

namespace App\Controller;

use App\Entity\FileUpload;
use App\Entity\Post;
use App\Entity\Tags;
use App\Entity\UploadMediaType;
use App\Entity\User;
use App\Form\FileUploadType;
use App\Form\PostType;
use App\Repository\PostRepository;
use App\Repository\TagsRepository;
use App\Security\JwtAuthenticator;
use Lexik\Bundle\JWTAuthenticationBundle\Encoder\JWTEncoderInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Security\Core\Exception\BadCredentialsException;
//use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Aws\S3\S3Client;
use Aws\CommandPool;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Exception\CustomUserMessageAuthenticationException;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Cocur\Slugify\Slugify;

class PostController extends AbstractController
{

    public function __construct(JwtAuthenticator $jwtEncoder, JWTEncoderInterface $jwtEncoderIn)
    {
        $this->jwtEncoder = $jwtEncoder;
        $this->jwtEncoderIn = $jwtEncoderIn;

    }

    public function init(Request $request){
        if(!$this->jwtEncoder->supports($request)){
            return new JsonResponse(['status' => '0', 'message' => 'Invalid Json Request']);
        }
    }

    /**
     * @Route("/post", name="post")
     */
    public function index()
    {
        return $this->render('post/index.html.twig', [
            'controller_name' => 'PostController',
        ]);
    }

    /**
     * @Route(path="/api/post", name="post")
     * @Method("POST")
     */
    public function postRegisterAction(Request $request,S3Client $s3Client)
    {
        if ($this->jwtEncoder->supports($request)) {


            $post = new Post();
            $form = $this->createForm(PostType::class, $post);
            $form->handleRequest($request);
            $em = $this->getDoctrine()->getManager();
            // if ($form->isValid()) {
                $preAuthToken = $this->jwtEncoder->getCredentials($request);
                $data = $this->jwtEncoderIn->decode($preAuthToken);
                $username = $data['username'];
                $tagName = $request->get('tags');
                if (!empty( $request->get('tags'))) {
                    $tag = $em->getRepository(Tags::class)->findOneBy(['name' => $tagName]);
                } else{
                    $tag = $em->getRepository(Tags::class)->findOneBy(['name' => 'others']);
                }
                $imgname = $request->get('fileName');
                if ($request->get('fileName')) {
                 $fileEntity =   $this->uploadForm($request,$s3Client);
                 
                 $ext = pathinfo($fileEntity->getFile() . "/" .$fileEntity->getFilename() , PATHINFO_EXTENSION);
                 $UploadTypeName = $em->getRepository(UploadMediaType::class)->findOneBy(['mediaType' =>strtolower($ext)]);
                } else { 
                    $fileEntity = new FileUpload();
                    $UploadTypeName = $em->getRepository(UploadMediaType::class)->findOneBy(['mediaType' =>'mp4']);
                }
                
                $slugify = new Slugify();
                $slug = $slugify->slugify($post->getName(), '_');
                $numOfBytes = 5;
                $randomBytes = random_bytes($numOfBytes);
                $randomString = base64_encode($randomBytes);

                $user = $em->getRepository(User::class)->findOneBy(['username' => $username]);
                $post->setCreated(new \DateTime());
                $post->setPostuser($user);
                $post->setPosttag($tag);
                $post->setPosturl($slug . "-" . $randomString);
                $post->addPostfile($fileEntity);
                $post->setMediaTypeUpload($UploadTypeName);
                $post->setStatus(true);
                $em->persist($post);
                $em->flush();

                return new JsonResponse(['status' => 'ok', 'data' => $imgname]);
            // }
        }
        throw new HttpException(400, "Invalid data");
    }

    /**
     * @Route(path="/api/posts", name="getposts")
     * @Method("GET")
     */
    public function getAllPost(PostRepository $postRepository)
    {
        $data = $postRepository->findAll();

        return new JsonResponse(['status' => 'ok', 'data' => $data]);
    }

    /**
     * @Route(path="/api/postById", name="postById")
     * @Method("POST")
     */
    public function getPostById(Request $request, PostRepository $postRepository)
    {
        if ($this->jwtEncoder->supports($request)) {
            $preAuthToken = $this->jwtEncoder->getCredentials($request);
            $data = $this->jwtEncoderIn->decode($preAuthToken);
            $username = $data['username'];
            $em = $this->getDoctrine()->getManager();
            $user = $em->getRepository(User::class)->findOneBy(['username' => $username]);
            //$userDetails = $em->getRepository(User::class)->findByUsersActive();
            $postDetails = array();         
            $role = $user->getRoles();
            // foreach ($userDetails as $key => $value) {
            //    $userDetails[$key] = $value;
            //    $id = $value['id'];
            //    $pDetails = $em->getRepository(Post::class)->findByPostsById($id);
            //    foreach ($pDetails as $pkey => $pvalue) {
            //     $postDetails[$pkey]['posts'] = $pvalue;    
            //    }
            // //    $userDetails[$key]['posts'] = $pvalue; 
               
            // }
            // if (in_array('ROLE_USER', $role)) {
            //     $userd = $this->roleUser();
            //     return $userd;
            // } else if ($role == 'ROLE_ADMIN==') { }
            // $userd = $em->getRepository(Post::class)->findBy(['postuser' => $user->getId()]);
            $userd = $this->roleUser();
            // foreach ($userd as $key => $value) {
            //     $id = $value['id'];
            //     $pDetails = $em->getRepository(Post::class)->findByPostsById($id);
            //     foreach ($pDetails as $pkey => $pvalue) {
            //         $value['posts'] = $pvalue;
            //         $a[$pkey] = $value;
                    
            //     }
            //     $new[$key] = $value;
            //     $new[$key]['posts'] = $pDetails; 
            //  }
            return $userd;
        }
        return new JsonResponse(['status' => 'f']);
    }


    /**
     * @Route(path="/api/postByTag/{tag}", name="postByTag")
     * @Method("GET")
     */
    public function getPostByTag(Request $request, TagsRepository $tagsRepository, $tag)
    {
        if ($this->jwtEncoder->supports($request)) {
            $preAuthToken = $this->jwtEncoder->getCredentials($request);
            $data = $this->jwtEncoderIn->decode($preAuthToken);
            $username = $data['username'];
            $em = $this->getDoctrine()->getManager();
            $user = $em->getRepository(User::class)->findOneBy(['username' => $username]);
            $tags = $em->getRepository(Tags::class)->findOneBy(['name' => $tag]);
            $userd = $em->getRepository(Post::class)->findBy(['postuser' => $user->getId(), 'posttag' => $tags->getId()]);

            return $userd;
        }
        return new JsonResponse(['status' => $request->headers->has('Authorization')]);
    }



    /**
     * @Route(path="/api/upload", name="upload")
     * @Method("POST")
     */
    public function upload(Request $request, S3Client $s3Client)
    {
        try {
            //$h = $request->headers->has('Authorization');
            if ($this->jwtEncoder->supports($request)) {
                $preAuthToken = $this->jwtEncoder->getCredentials($request);
                $data = $this->jwtEncoderIn->decode($preAuthToken);
                if ($data == false) {
                    throw new CustomUserMessageAuthenticationException('Expired Token');
                } else {
                    $fileupload = new FileUpload();
                    $form = $this->createForm(FileUploadType::class, $fileupload);
                    $form->handleRequest($request);
                    $filName = $request->files->get('file');
                    //$fileName = $fileupload->getFile();
                    if ($form->isValid()) {
                        $fileName = $fileupload->getFile();
                        $fff = $fileupload->getName();
                        $em = $this->getDoctrine()->getManager();
                        $username = $data['username'];
                        $ext = pathinfo($fileName . "/" . $fff, PATHINFO_EXTENSION);
                        //$key =   $request->request->get('file');

                        // $cmd = $s3Client->getCommand('PutObject', [
                        //     'Bucket' => $this->getParameter('app.s3.bucket.demo'),
                        //     'ACL' => 'public-read',
                        //     'Key' => $request->request->get('name'),
                        //     'SourceFile' => '/home/nishith/Downloads/green-circle.png',
                        // ]);    


                        $result = $s3Client->putObject([
                            'Bucket' => $this->getParameter('app.s3.bucket.demo'),
                            'ACL' => 'public-read',
                            'Key'    => $username . "/" . $fff,
                            'Body'   => 'this is the body!',
                            'SourceFile' => $fileName
                        ]);
                        // $signedRequest = $s3Client->createPresignedRequest($cmd, '+20 minutes');
                        // $result = $s3Client->execute($cmd);
                        // $response = new JsonResponse([
                        //     'signedUrl' => (string) $signedRequest->getUri(),
                        //     'imageUrl' => sprintf("https://%s.s3.amazonaws.com/%s", 
                        //         'my-blog-19',
                        //         $request->request->get('name')
                        //     )
                        // ], Response::HTTP_OK);


                        $fileupload->setUploadedAt(new \DateTime());
                        $etag = str_replace("\"", "", $result->get('ETag'));
                        $fileupload->setEtag($etag . "." . $ext);
                        $fileupload->setImageUrl($result->get('ObjectURL'));
                        $em->persist($fileupload);
                        $em->flush();
                    }
                    return $result;
                }
            }
        } catch (\Exception $exception) {

            return new JsonResponse([
                'success' => $request->get('name'),
                'code'    => $exception->getCode(),
                'message' => $exception->getMessage(),
            ], Response::HTTP_SERVICE_UNAVAILABLE);
        }
    }

    public function uploadForm($request, $s3Client)
    {
        if ($this->jwtEncoder->supports($request)) {
            $preAuthToken = $this->jwtEncoder->getCredentials($request);
            $data = $this->jwtEncoderIn->decode($preAuthToken);
            if ($data == false) {
                throw new CustomUserMessageAuthenticationException('Expired Token');
            } else {
                $fileupload = new FileUpload();
                $uploadType = new UploadMediaType();
                
                $form = $this->createForm(FileUploadType::class, $fileupload);
                $form->handleRequest($request);
                $filName = $request->files->get('file');
                //$fileName = $fileupload->getFile();
                // if ($form->isValid()) {
                    $fileName = $fileupload->getFile();
                    $fff = $fileupload->getFilename();
                    $em = $this->getDoctrine()->getManager();
                    $username = $data['username'];
                    $ext = pathinfo($fileName . "/" . $fff, PATHINFO_EXTENSION);
                    $UploadTypeName = $em->getRepository(UploadMediaType::class)->findOneBy(['mediaType' =>strtolower($ext)]);

                    //$key =   $request->request->get('file');

                    // $cmd = $s3Client->getCommand('PutObject', [
                    //     'Bucket' => $this->getParameter('app.s3.bucket.demo'),
                    //     'ACL' => 'public-read',
                    //     'Key' => $request->request->get('name'),
                    //     'SourceFile' => '/home/nishith/Downloads/green-circle.png',
                    // ]);    


                    $result = $s3Client->putObject([
                        'Bucket' => $this->getParameter('app.s3.bucket.demo'),
                        'ACL' => 'public-read',
                        'Key'    => $username . "/".$ext."/".$fff,
                        'Body'   => 'this is the body!',
                        'SourceFile' => $fileName
                    ]);         
                    $fileupload->setUploadedAt(new \DateTime());
                    $etag = str_replace("\"", "", $result->get('ETag'));
                    $fileupload->setEtag($etag . "." . $ext);
                    $fileupload->setImageUrl($result->get('ObjectURL'));
                    $em->persist($fileupload);
                    $em->flush();
                    return $fileupload;
                    //return new JsonResponse(['fileDetails' => $fileupload,'uploadMediaTypeName'=>$UploadTypeName]);
                // }
            }
        }
    }

    /**
     * @Route(path="/api/uploads", name="uploads")
     * @Method("POST")
     */
    public function uploads(Request $request, S3Client $s3Client)
    {
        if ($this->jwtEncoder->supports($request)) {
            $preAuthToken = $this->jwtEncoder->getCredentials($request);
            $data = $this->jwtEncoderIn->decode($preAuthToken);
            if ($data == false) {
                throw new CustomUserMessageAuthenticationException('Expired Token');
            } else {
                // $fileupload = new FileUpload();
                // $form = $this->createForm(FileUploadType::class, $fileupload);
                // $form->handleRequest($request);
                // $filName = $request->files->get('file');
                // //$fileName = $fileupload->getFile();
                // if ($form->isValid()) {
                //     $fileName = $fileupload->getFile();
                //     $fff = $fileupload->getName();

                $username = $data['username'];
                // $response = $s3Client->getObject(array(
                //     'Bucket' => $this->getParameter('app.s3.bucket.demo'),
                //     'Key' => "karthikboddu/green-circle.png",
                //     'SaveAs' => '/home/karthik/Downloads/elsfrance/green-circle.png'
                // ));
                $objects = $s3Client->getIterator('ListObjects', array(
                    "Bucket" => $this->getParameter('app.s3.bucket.demo'),
                    "Prefix" => $username . "/" //must have the trailing forward slash "/"

                ));

                foreach ($objects as $object) {
                    // Do something with the object 
                    $key = $object['Key'];
                    $ext = pathinfo($key, PATHINFO_EXTENSION);

                    //$etag = stripslashes($object['ETag']);
                    $etag = str_replace("\"", "", $object['ETag']);
                    $response = $s3Client->getObject(array(
                        'Bucket' => $this->getParameter('app.s3.bucket.demo'),
                        'Key' => $object['Key'],
                        'SaveAs' => "/home/karthik/Documents/Symfony/src/assets/" . $etag . "." . $ext
                    ));
                }

                //   $body = $response->get('Body');
                // $body->rewind();

                return $response;
            }
        }
        return "f";
    }

    /**
     * @Route(path="/api/test/{tag}", name="uploadstag")
     * @Method("GET")
     */
    public function test(Request $request, $tag)
    {
        // if ($this->jwtEncoder->supports($request)) {
        // }
        //     $preAuthToken = $this->jwtEncoder->getCredentials($request);
        //     $data = $this->jwtEncoderIn->decode($preAuthToken);
        $slugify = new Slugify();
        $slug = $slugify->slugify($tag, '_');
        $numOfBytes = 5;
        $randomBytes = random_bytes($numOfBytes);
        $randomString = base64_encode($randomBytes);
        // $slugurl = $slug."-".$random;
        // if ($data == false) 
        //     throw new CustomUserMessageAuthenticationException('Expired Token');
        // } else {
        //     // $fileupload = new FileUpload();
        //     // $form = $this->createForm(FileUploadType::class, $fileupload);
        //     // $form->handleRequest($request);
        //     // $filName = $request->files->get('file');
        //     // //$fileName = $fileupload->getFile();
        //     // if ($form->isValid()) {
        //     //     $fileName = $fileupload->getFile();
        //     //     $fff = $fileupload->getName();

        //     $username = $data['username'];

        //     return $result;
        // }
        return $randomString;
    }


    /**
     * @Route(path="/api/viewPostByUser/{tag}", name="viewpost")
     * @Method("GET")
     */
    public function getPostByTagUser(Request $request, $tag)
    {
        // if ($this->jwtEncoder->supports($request)) {
        // }
        //     $preAuthToken = $this->jwtEncoder->getCredentials($request);
        //     $data = $this->jwtEncoderIn->decode($preAuthToken);
        $em = $this->getDoctrine()->getManager();
        $postDat = array();
        $postData = $em->getRepository(Post::class)->findOneBy(['posturl' => $tag]);
        $postDat[0] = $postData;
        // if ($data == false) {
        //     throw new CustomUserMessageAuthenticationException('Expired Token');
        // } else {
        //     // $fileupload = new FileUpload();
        //     // $form = $this->createForm(FileUploadType::class, $fileupload);
        //     // $form->handleRequest($request);
        //     // $filName = $request->files->get('file');
        //     // //$fileName = $fileupload->getFile();
        //     // if ($form->isValid()) {
        //     //     $fileName = $fileupload->getFile();
        //     //     $fff = $fileupload->getName();

        //     $username = $data['username'];

        //     return $result;
        // }
        return $postDat;
    }


    /**
     * @Route(path="/api/testing", name="testing")
     * @Method("GET")
     */
    public function roleUser()
    {
        $user = $this->getDoctrine()->getRepository(Post::class)->findByUsersRoles();
        return $user;
    }


    /**
     * @Route(path="/api/postsByHomeScreen", name="postsbyhomescreen")
     * @Method("GET")
     */
    public function postsByHomeScreen(){

            $em = $this->getDoctrine()->getManager();
            $userd = $this->getDoctrine()->getRepository(Post::class)->findByAllUserHomePosts();
            // if (in_array('ROLE_USER', $role)) {
            //     $userd = $this->roleUser();
            //     return $userd;
            // } else if ($role == 'ROLE_ADMIN==') { }
            // $userd = $em->getRepository(Post::class)->findBy(['postuser' => $user->getId()]);
            
            $data = array($userd);
            return $data;
        
        
    }

    /**
     * @Route(path="/api/admin/totalPostsByActive", name="totalPostsByActive")
     * @Method("GET")
     */
    public function totalPostsByActive(){
        $userd = $this->getDoctrine()->getRepository(Post::class)->findByTotalActivePosts();
        return $userd[0]['totalposts'];
    }
    
}
