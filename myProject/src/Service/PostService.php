<?php

namespace App\Service;

use App\Entity\User;
use App\Entity\Post;
use App\Entity\UserTypeMaster;
use App\Entity\UserPostUpload;
use Doctrine\ORM\EntityManagerInterface;
use FOS\RestBundle\Controller\FOSRestController;
use Lexik\Bundle\JWTAuthenticationBundle\Encoder\JWTEncoderInterface;

class PostService extends FOSRestController
{
    private $em;

    private $jwtEncoder;

    public function __construct(EntityManagerInterface $em, JWTEncoderInterface $jwtEncoder)
    {
        $this->em = $em;
        $this->jwtEncoder = $jwtEncoder;

    }


    public function flushAllPostUpload($eachUserFileId,$user,$post)
    {
        $userTypeMaster = new UserPostUpload();
        $userTypeMaster->setFkUploadId($eachUserFileId);
        $userTypeMaster->setFkUserId($user);
        $userTypeMaster->setFkPostId($post);
        try {
            
            $this->em->persist($userTypeMaster);
            $this->em->flush();
            return $userTypeMaster->getId();
        } catch (\Doctrine\ORM\ORMException $e) {
           
        }
        //return $user;
    }

    public function newPost(){

    }


    public function findByPostsByPostId(){
        try {
            
        } catch (\Throwable $th) {
            //throw $th;
        }           
    }
    

}
