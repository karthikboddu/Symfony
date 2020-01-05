<?php

namespace App\Service;

use App\Entity\User;
use App\Entity\Post;
use App\Entity\UserTypeMaster;
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

    public function insertUser(User $user, $password)
    {
        try {
            // $em = $em->getDoctrine()->getManager();
            $user->setPassword($password);
            $user->setRoles(['ROLE_USER']);
            $user->setAccountstatus(['IN_ACTIVE']);
            $user->setCreatedAt(new \DateTime());
            $user->setActive(true);
            $userType = $this->em->getRepository(UserTypeMaster::class)->findOneBy(['name' => 'ROLE_USER']);
            $user->setFkUserType($userType);

            $this->em->persist($user);
            $this->em->flush();

            return $user->getId();
        } catch (\Throwable $th) {
            //throw $th;
        }

    }

    public function newPost(){

    }


}
