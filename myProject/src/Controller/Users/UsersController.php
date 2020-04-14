<?php

namespace App\Controller\Users;

use App\Entity\User;
use App\Security\JwtAuthenticator;
use Lexik\Bundle\JWTAuthenticationBundle\Encoder\JWTEncoderInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class UsersController extends AbstractController
{

    public function __construct(JwtAuthenticator $jwtEncoder, JWTEncoderInterface $jwtEncoderIn)
    {
        $this->jwtEncoder = $jwtEncoder;
        $this->jwtEncoderIn = $jwtEncoderIn;
        
    }



    /**
     * @Route("/api/users/fetchactiveusers", name="fetchactiveusers"    )
     */
    public function getActiveUsers()
    {
        $em = $this->getDoctrine()->getManager();
        $postData = $em->getRepository(User::class)->findByUsersActive();
        return $postData;
    }

    

    /**
     * @Route("/api/admin/getNumberUsers", name="getNumberUsers")
     */
    public function getNumberOfUsers()
    {
        $em = $this->getDoctrine()->getManager();
        $postData = $em->getRepository(User::class)->findByCountUers();
        return $postData;
    }
}
