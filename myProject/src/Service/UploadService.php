<?php

namespace App\Service;

use App\Entity\User;
use App\Entity\Post;
use App\Entity\UserTypeMaster;
use Doctrine\ORM\EntityManagerInterface;
use FOS\RestBundle\Controller\FOSRestController;
use Lexik\Bundle\JWTAuthenticationBundle\Encoder\JWTEncoderInterface;

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


}