<?php

namespace App\Service;

use App\Entity\User;
use App\Entity\UserTypeMaster;
use Doctrine\ORM\EntityManagerInterface;
use FOS\RestBundle\Controller\FOSRestController;
use Lexik\Bundle\JWTAuthenticationBundle\Encoder\JWTEncoderInterface;

class UserServices extends FOSRestController
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

    public function isUserExists(User $user)
    {
        try {
            $userExists = $this->em->getRepository(User::class)->findOneBy(['username' => $user->getUsername()]);
            if($userExists){
                return true;
            }else{
                return false;
            }
        } catch (\Throwable $th) {
            //throw $th;
        }
    }






    // {"name": "srikanth", "surname": "boddu", "username": "srikanthkboddu", "password": "srikanth", "phonenumber": 9030493600,"email":"srikanth@gmail.com"}
}
