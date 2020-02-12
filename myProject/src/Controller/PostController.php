<?php

namespace App\Controller;

use App\Entity\FileUpload;
use App\Entity\Post;
use App\Entity\Tags;
use App\Entity\UploadMediaType;
use App\Entity\User;
use App\Entity\UserPostUpload;
use App\Form\FileUploadType;
use App\Form\PostType;
use App\Repository\PostRepository;
use App\Repository\TagsRepository;
use App\Security\JwtAuthenticator;
use App\Service\PostService;
use Aws\S3\S3Client;
use Cocur\Slugify\Slugify;
use Lexik\Bundle\JWTAuthenticationBundle\Encoder\JWTEncoderInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
//use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Exception\CustomUserMessageAuthenticationException;

class PostController extends AbstractController
{

    public function __construct(JwtAuthenticator $jwtEncoder, JWTEncoderInterface $jwtEncoderIn, PostService $postService)
    {
        $this->jwtEncoder = $jwtEncoder;
        $this->jwtEncoderIn = $jwtEncoderIn;
        $this->postService = $postService;
    }

    public function init(Request $request)
    {
        if (!$this->jwtEncoder->supports($request)) {
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
    public function postRegisterAction(Request $request, S3Client $s3Client)
    {
        try {
            if ($this->jwtEncoder->supports($request)) {

                $post = new Post();
                $userTypeMaster = new UserPostUpload();
                $form = $this->createForm(PostType::class, $post);
                $form->handleRequest($request);
                $em = $this->getDoctrine()->getManager();
                // if ($form->isValid()) {
                $preAuthToken = $this->jwtEncoder->getCredentials($request);
                $data = $this->jwtEncoderIn->decode($preAuthToken);
                $username = $data['username'];
                $tagName = $request->get('tags');
                if (!empty($request->get('tags'))) {
                    $tag = $em->getRepository(Tags::class)->findOneBy(['name' => $tagName]);
                } else {
                    $tag = $em->getRepository(Tags::class)->findOneBy(['name' => 'Others']);
                }
                $imgId = $request->get('file');
                if ($imgId) {
                    $userFileUploadId = explode(",", $imgId);
                }
                // if ($request->get('fileName')) {
                //     $fileEntity = $this->uploadForm($request, $s3Client);

                //     $ext = pathinfo($fileEntity->getFile() . "/" . $fileEntity->getFilename(), PATHINFO_EXTENSION);
                //     $UploadTypeName = $em->getRepository(UploadMediaType::class)->findOneBy(['mediaType' => strtolower($ext)]);
                // } else {
                //     $fileEntity = new FileUpload();
                //     $UploadTypeName = $em->getRepository(UploadMediaType::class)->findOneBy(['mediaType' => 'mp4']);
                // }

                $slugify = new Slugify();
                $slug = $slugify->slugify($post->getName(), '_');
                $numOfBytes = 5;
                $randomBytes = random_bytes($numOfBytes);
                $randomString = base64_encode($randomBytes);

                $user = $em->getRepository(User::class)->findOneBy(['username' => $username]);
                $post->setCreated(new \DateTime());
                // $post->setPostuser($user);
                $post->setPosttag($tag);
                $post->setPosturl($slug . "-" . $randomString);
                $post->setStatus(true);
                $em->persist($post);
                $em->flush();
                $gg = '';
                // foreach ($userFileUploadId as $key => $value) {
                //     $eachUserFileId = $em->getRepository(FileUpload::class)->findOneBy(['id' => $value]);
                //     $gg = " " . $key . " " . $gg;
                //     $userTypeMaster->setFkUploadId($eachUserFileId);
                //     $userTypeMaster->setFkUserId($user);
                //     $userTypeMaster->setFkPostId($post);
                //     $em->persist($userTypeMaster);
                //     if (($key + 1) % sizeof($userFileUploadId) === 0) {
                //         $em->flush();
                //         $em->clear();
                //         // Detaches all objects from Doctrine!
                //     }
                // }

                $batchSize = 5;
                $currentSize = 0;

                foreach ($userFileUploadId as $item) {
                    $eachUserFileId = $em->getRepository(FileUpload::class)->findOneBy(['id' => $item]);
                    $s = $this->postService->flushAllPostUpload($eachUserFileId, $user, $post);
                    $s = " " . $s;

                }

                // $em->flush();
                // $em->clear();
                //$post->setMediaTypeUpload($UploadTypeName);

                return new JsonResponse(['status' => 'ok', 'data' => $s]);
                // }
            }
        } catch (\Exception $e) {
            //throw $th; 'message' => $exception->getMessage(),
            // throw new HttpException(400, "Invalid data");
            return new JsonResponse(['status' => '0', 'message' => $e->getMessage()]);
        }

    }

    /**
     * @Route(path="/api/admin/posts", name="getposts")
     * @Method("GET")
     */
    public function getAllPost()
    {
        //$data = $postRepository->findAll();
        $em = $this->getDoctrine()->getManager();
        $user = $em->getRepository(Post::class)->findByAdminAllPosts();
        return $user;
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
                    $userPostUpload = new UserPostUpload();
                    $form = $this->createForm(FileUploadType::class, $fileupload);
                    $form->handleRequest($request);
                    $filName = $request->files->get('file');
                    $fileName = $fileupload->getFile();
                    // if ($form->isValid()) {
                    $fileName = $fileupload->getFile();
                    $fff = $fileupload->getFilename();
                    $em = $this->getDoctrine()->getManager();
                    $username = $data['username'];
                    $user = $em->getRepository(User::class)->findOneBy(['username' => $username]);
                    $ext = pathinfo($fileName . "/" . $fff, PATHINFO_EXTENSION);
                    //$key =   $request->request->get('file');

                    // $cmd = $s3Client->getCommand('PutObject', [
                    //     'Bucket' => $this->getParameter('app.s3.bucket.demo'),
                    //     'ACL' => 'public-read',
                    //     'Key' => $request->request->get('name'),
                    //     'SourceFile' => '/home/nishith/Downloads/green-circle.png',
                    // ]);

                    $UploadTypeName = $em->getRepository(UploadMediaType::class)->findOneBy(['mediaType' => strtolower($ext)]);
                    $result = $s3Client->putObject([
                        'Bucket' => $this->getParameter('app.s3.bucket.demo'),
                        'ACL' => 'public-read',
                        'Key' => $username . "/" . $ext . "/" . $fff,
                        'Body' => 'this is the body!',
                        'SourceFile' => $fileName,
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
                    $fileupload->setFileuplodtype($UploadTypeName);
                    $fileupload->setStatus(true);
                    $em->persist($fileupload);
                    $em->flush();

                    // $userPostUpload->setFkUploadId($fileupload);
                    // $userPostUpload->setFkUserId($user);
                    // //$user->addUserMediaType($UploadTypeName);

                    // $em->persist($userPostUpload);
                    // $em->flush();
                }
                return $fileupload->getId();
                // }
            }
        } catch (\Exception $exception) {

            return new JsonResponse([
                'success' => $request->get('name'),
                'code' => $exception->getCode(),
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
                $UploadTypeName = $em->getRepository(UploadMediaType::class)->findOneBy(['mediaType' => strtolower($ext)]);

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
                    'Key' => $username . "/" . $ext . "/" . $fff,
                    'Body' => 'this is the body!',
                    'SourceFile' => $fileName,
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
                    "Prefix" => $username . "/", //must have the trailing forward slash "/"

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
                        'SaveAs' => "/home/karthik/Documents/Symfony/src/assets/" . $etag . "." . $ext,
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
    public function postsByHomeScreen()
    {

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
    public function totalPostsByActive()
    {
        $userd = $this->getDoctrine()->getRepository(Post::class)->findByTotalActivePosts();
        return $userd[0]['totalposts'];
    }

    /**
     * @Route(path="/api/deleteObject", name="deleteObject")
     * @Method("GET")
     */
    public function deleteobject(S3Client $s3Client)
    {

        $result = $s3Client->deleteObject([
            'Bucket' => $this->getParameter('app.s3.bucket.demo'),
            'Key' => 'karthikboddu/mp',
        ]);

        return $result;

    }

    /**
     * @Route(path="/api/postfileUpload", name="postfileUpload")
     * @Method("GET")
     */
    public function postfileUpload(S3Client $s3Client, Request $request)
    {
        if ($this->jwtEncoder->supports($request)) {

            $preAuthToken = $this->jwtEncoder->getCredentials($request);
            $data = $this->jwtEncoderIn->decode($preAuthToken);
            if ($data == false) {
                throw new CustomUserMessageAuthenticationException('Expired Token');
            } else {
                $postfileUpload = $this->getDoctrine()->getRepository(Post::class)->findByFileUpload();
                return $postfileUpload;
            }

        }
    }

    /**
     * @Route(path="/api/postGroup", name="postGroup")
     * @Method("GET")
     */
    public function postGroup()
    {
        $allActivePosts = $this->getDoctrine()->getRepository(Post::class)->findByAllPostsActive();
        //$postfileUpload = $this->getDoctrine()->getRepository(Post::class)->findByGroup();

        // foreach ($allActivePosts as $value) {
        //     $allActivePostsUploadId = $this->getDoctrine()->getRepository(Post::class)->findByAllPostsActiveUploadId($value);
        // }
        $allActivePostsUploadId = $this->getDoctrine()->getRepository(Post::class)->findByAllPostsActiveUploadId($allActivePosts);

        $postfileUpload = $this->getDoctrine()->getRepository(Post::class)->findByGroup($allActivePostsUploadId);

        return $postfileUpload;
    }

    /**
     * @Route(path="/api/postGroupAll", name="postGroupAll")
     * @Method("GET")
     */
    public function postGroupAll(Request $request)
    {
       $limitId =  $request->get('id');
       $offsetId =  $request->get('offset');
       if(!$offsetId){
            $offsetId = '0';
       }
       if(!$limitId){
           $limitId = '5';
       }
       
        $postfileUpload = $this->getDoctrine()->getRepository(Post::class)->findByGroupAll($limitId,$offsetId);
        //return $postfileUpload;
        foreach ($postfileUpload as $key => $value) {
            $postfileUpload = $this->getDoctrine()->getRepository(Post::class)->findByPostsByPostId($value['post_id']);
            $fileUploadDetails='';
            $userDetails = '';
            if($value['upload_id']){
                $uploadIds = explode(",", $value['upload_id']);
                $fileUploadDetails = $this->getDoctrine()->getRepository(FileUpload::class)->findByUploadDetailsById($uploadIds);
            }
            if($value['user_id']){
                $userDetails = $this->getDoctrine()->getRepository(User::class)->findByUsersDetailsById($value['user_id']);

            }            
            if($postfileUpload  ){

            }
                            $newArrayy[$key] = array('user'=>$userDetails,'userPost'=>$postfileUpload,'uploadDetails'=>$fileUploadDetails);
            

        }
        $totalPosts = sizeof($newArrayy);        

        return new JsonResponse(['data' => $newArrayy,'totalPosts'=>$totalPosts]);
        return $newArrayy;
            
    }

}
