<?php

namespace App\Service;

use App\Entity\User;
use App\Entity\Post;
use App\Entity\UserTypeMaster;
use Doctrine\ORM\EntityManagerInterface;
use FOS\RestBundle\Controller\FOSRestController;
use Lexik\Bundle\JWTAuthenticationBundle\Encoder\JWTEncoderInterface;
use Aws\S3\S3Client;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\FileUpload;
use App\Entity\UserPostUpload;
use App\Form\FileUploadType;
use App\Entity\UploadMediaType;

class UploadService extends FOSRestController
{
    private $em;

    private $jwtEncoder;

    public function __construct(EntityManagerInterface $em, JWTEncoderInterface $jwtEncoder)
    {
        $this->em = $em;
        $this->jwtEncoder = $jwtEncoder;

    }


    // public function flushAllPostUpload($eachUserFileId,$user,$post)
    // {
    //     //$data = $postRepository->findAll();
    //     $em = $this->getDoctrine()->getManager();
    //    // $user = $em->getRepository(Post::class)->findByAdminAllPosts();
    //     $userTypeMaster->setFkUploadId($eachUserFileId);
    //     $userTypeMaster->setFkUserId($user);
    //     $userTypeMaster->setFkPostId($post);
    //     try {
    //         $currentSize++;
    //         $em->persist($userTypeMaster);
    //         $em->flush();
    //         return $userTypeMaster->getId();
    //     } catch (\Doctrine\ORM\ORMException $e) {
           
    //     }
    //     //return $user;
    // }

    public function newPost(){

    }

    public function uploadser(Request $request, S3Client $s3Client,$user)
    {
        try {
            //$h = $request->headers->has('Authorization');
            
                
                    $fileupload = new FileUpload();
                    $userPostUpload = new UserPostUpload();
                    $filName = $request->files->get('file');
                    $fileName = $fileupload->getFile();
                    // if ($form->isValid()) {
                    $fileName = $fileupload->getFile();
                    $fff = $fileupload->getFilename();
                    $ext = pathinfo($fileName . "/" . $fff, PATHINFO_EXTENSION);
                    //$key =   $request->request->get('file');

                    // $cmd = $s3Client->getCommand('PutObject', [
                    //     'Bucket' => $this->getParameter('app.s3.bucket.demo'),
                    //     'ACL' => 'public-read',
                    //     'Key' => $request->request->get('name'),
                    //     'SourceFile' => '/home/nishith/Downloads/green-circle.png',
                    // ]);

                    $UploadTypeName = $this->em->getRepository(UploadMediaType::class)->findOneBy(['mediaType' => strtolower($ext)]);
                    $result = $s3Client->putObject([
                        'Bucket' => 'my-blog-19',
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
                    $this->em->persist($fileupload);
                    $this->em->flush();

                    // $userPostUpload->setFkUploadId($fileupload);
                    // $userPostUpload->setFkUserId($user);
                    // //$user->addUserMediaType($UploadTypeName);

                    // $em->persist($userPostUpload);
                    // $em->flush();
                
                return $fileupload->getId();
                // }
            
        } catch (\Exception $exception) {

            return new JsonResponse([
                'success' => $request->get('name'),
                'code' => $exception->getCode(),
                'message' => $exception->getMessage(),
            ], Response::HTTP_SERVICE_UNAVAILABLE);
        }
    }


    public function flushAllFileUploadToFolder($eachUserFileId,$user,$folderId)
    {
        $userTypeMaster = new UserPostUpload();
        $userTypeMaster->setFkUploadId($eachUserFileId);
        $userTypeMaster->setFkUserId($user);
        $userTypeMaster->setFkUserFolder($folderId);
        try {
            
            $this->em->persist($userTypeMaster);
            $this->em->flush();
            return $userTypeMaster->getId();
        } catch (\Doctrine\ORM\ORMException $e) {
           
        }
        //return $user;
    }


}
