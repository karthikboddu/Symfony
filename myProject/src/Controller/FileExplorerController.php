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

    /**
     * @Route("/api/File/addFileExp", name="file_add_file")
     */
    public function addFile(Request $request)
    {
        $id = $request->get('fid');
        $name = $request->get('name');
        $isFolder = $request->get('isFolder');
        $parent = $request->get('parent');
        $fileExplorer = new FileExplorer();
        $fileExplorer->setFid($id);
        $fileExplorer->setName($name);
        $fileExplorer->setIsFolder($isFolder);
        $fileExplorer->setParent($parent);
        $fileExplorer->setCreatedAt(new \DateTime());
        $em = $this->getDoctrine()->getManager();
        $em->persist($fileExplorer);
        $em->flush();
        $fid = $fileExplorer->getFid();
        $postfileUpload = $this->getDoctrine()->getRepository(FileExplorer::class)->findByFoldersByfId($fid);
        //$fileElement = $postfileUpload['0']['uploadDetails'];
        return new JsonResponse(['data' => $postfileUpload['0'],'status'=>'','message'=>'']);
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
