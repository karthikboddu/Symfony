<?php

namespace App\Controller;
use App\Entity\FileExplorer;
use App\Entity\User;
use App\Entity\Post;
use App\Entity\FileUpload;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Lexik\Bundle\JWTAuthenticationBundle\Encoder\JWTEncoderInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\Exception\CustomUserMessageAuthenticationException;
use App\Security\JwtAuthenticator;
use App\Service\PostService;
use App\Service\UploadService;


class FileExplorerController extends AbstractController
{
    /**
     * @Route("/file/explorer", name="file_explorer")
     */
    public function index()
    {
        return $this->render('file_explorer/index.html.twig', [
            'controller_name' => 'FileExplorerController',
        ]);
    }

    public function __construct(JwtAuthenticator $jwtEncoder, JWTEncoderInterface $jwtEncoderIn, PostService $postService,UploadService $uploadService)
    {
        $this->jwtEncoder = $jwtEncoder;
        $this->jwtEncoderIn = $jwtEncoderIn;
        $this->postService = $postService;
        $this->uploadService = $uploadService;
    }
    
    /**
     * @Route("/api/File/addFileExp", name="file_add_file")
     */
    public function addFile(Request $request)
    {
        try {
            if ($this->jwtEncoder->supports($request)) {
                $preAuthToken = $this->jwtEncoder->getCredentials($request);
                $data = $this->jwtEncoderIn->decode($preAuthToken);
                $em = $this->getDoctrine()->getManager();
                $username = $data['username'];
                $user = $em->getRepository(User::class)->findOneBy(['username' => $username]);
                $id = $request->get('fid');
                $name = $request->get('name');
                $isFolder = $request->get('isFolder');
                $parent = $request->get('parent');
                $uploadIds = $request->get('ufId');
                $uIds = json_decode($uploadIds,true);
                $fileExplorer = new FileExplorer();
                $fileExplorer->setFid($id);
                $fileExplorer->setName($name);
                $fileExplorer->setIsFolder($isFolder);
                $fileExplorer->setParent($parent);
                $fileExplorer->setCreatedAt(new \DateTime());
                $em = $this->getDoctrine()->getManager();
                $em->persist($fileExplorer);
                $em->flush();
                $folderId = $fileExplorer->getFid();
                if(!empty($uIds)){
                    $folderDetails = $em->getRepository(FileExplorer::class)->findOneBy(['fid' => $folderId]);
                    
                    foreach ($uIds as $item) {
                        $eachUserFileId = $em->getRepository(FileUpload::class)->findOneBy(['id' => $item]);
                        $s = $this->uploadService->flushAllFileUploadToFolder($eachUserFileId, $user, $folderDetails);
        
                    }
        
                }
                return new JsonResponse(['status' => 'ok', 'data' => '']);
            }
    }catch (\Exception $e) {
        //throw $th; 'message' => $exception->getMessage(),
        // throw new HttpException(400, "Invalid data");
        return new JsonResponse(['status' => '0', 'message' => $e->getMessage()]);
    }
    }

    /**
     * @Route("/api/file/getFileExp", name="file_get_file")
     */
    public function getFileExp(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $files = $em->getRepository(FileExplorer::class)->findAll();
        return $files;
    }


    /**
     * @Route(path="/api/file/folderGroupAll", name="folderGroupAlls")
     * @Method("GET")
     */
    public function postGroupAll(Request $request)
    {
       // $limitId =  $request->get('id');
       // $offsetId =  $request->get('offset');
       // if(!$limitId){
       //     $limitId = '5';
       // }
        $newArrayy = array();
        $postfileUpload = $this->getDoctrine()->getRepository(FileExplorer::class)->findByFolderAll($limitId='',$offsetId='');
        //return $postfileUpload;
        foreach ($postfileUpload as $key => $value) {
            //$postfileUpload = $this->getDoctrine()->getRepository(Post::class)->findByPostsByPostId($value['post_id']);
            $fileUploadDetails='';
            $userDetails = '';
            if($value['upload_id']){
                $uploadIds = explode(",", $value['upload_id']);
                $fileUploadDetails = $this->getDoctrine()->getRepository(FileUpload::class)->findByUploadDetailsById($uploadIds);
            }
            if($value['user_id']){
                $userDetails = $this->getDoctrine()->getRepository(User::class)->findByUsersDetailsById($value['user_id']);

            }
            if($value['folder_id']){
                $folderDetails = $this->getDoctrine()->getRepository(FileExplorer::class)->findByFoldersById($value['folder_id']);

            }              

            // if($postfileUpload  ){

            // }
                            $newArrayy[$key] = array('user'=>$userDetails,'uploadDetails'=>$fileUploadDetails,'folderDetails'=>$folderDetails);
            

        }
        $totalPosts = sizeof($newArrayy);        

        return new JsonResponse(['data' => $newArrayy,'totalPosts'=>$totalPosts]);
        return $newArrayy;
            
    }


   /**
     * @Route(path="/api/folderGroupAll/{fid}", name="folderGroupAll")
     * @Method("GET")
     */
    public function postGroupByfId(Request $request,$fid)
    {
       // $limitId =  $request->get('id');
       // $offsetId =  $request->get('offset');
       // if(!$limitId){
       //     $limitId = '5';
       // }
       $newArrayy = array();
        $postfileUpload = $this->getDoctrine()->getRepository(FileExplorer::class)->findByFolderByfId($limitId='',$offsetId='',$fid);
        //return $postfileUpload;
        foreach ($postfileUpload as $key => $value) {
            //$postfileUpload = $this->getDoctrine()->getRepository(Post::class)->findByPostsByPostId($value['post_id']);
            $fileUploadDetails='';
            $userDetails = '';
            if($value['upload_id']){
                $uploadIds = explode(",", $value['upload_id']);
                $fileUploadDetails = $this->getDoctrine()->getRepository(FileUpload::class)->findByUploadDetailsById($uploadIds);
            }
            if($value['user_id']){
                $userDetails = $this->getDoctrine()->getRepository(User::class)->findByUsersDetailsById($value['user_id']);

            }
            if($value['folder_id']){
                $folderDetails = $this->getDoctrine()->getRepository(FileExplorer::class)->findByFoldersById($value['folder_id']);

            }              

            // if($postfileUpload  ){

            // }
                            $newArrayy[$key] = array('user'=>$userDetails,'uploadDetails'=>$fileUploadDetails,'folderDetails'=>$folderDetails);
            

        }
        $totalPosts = sizeof($newArrayy);        

        // return new JsonResponse(['data' => $newArrayy,'totalPosts'=>$totalPosts]);
        return $newArrayy;
            
    }    

}
