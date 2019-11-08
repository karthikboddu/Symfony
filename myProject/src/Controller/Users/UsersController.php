<?php

namespace App\Controller\Users;

use App\Entity\User;
use App\Security\JwtAuthenticator;
use Lexik\Bundle\JWTAuthenticationBundle\Encoder\JWTEncoderInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
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
        $user = new User();
        $user->setRoles(['ROLE_USER']);
        $userRole = $user->getRoles();
        //$tag = $em->getRepository(User::class)->findOneBy(['roles' => $userRole]);
        $postData = $em->getRepository(User::class)->findUsersByRole($userRole[0]);
        return $postData;
    }

    

    /**
     * @Route("/api/admin/getNumberUsers", name="getNumberUsers")
     */
    public function getNumberOfUsers()
    {
        $em = $this->getDoctrine()->getManager();
        $postData = $em->getRepository(User::class)->findByCountUers();
        return $postData[0]['NoOfUsers'];
    }

    /**
     * @Route("/api/admin/deleteUser", name="deleteUser")
     */
    public function deleteUsers(Request $request)
    {
        $u_id = $request->get('u_id');
        $em = $this->getDoctrine()->getManager();
        $userEntity = new User();
        $userEntity = $em->getRepository(User::class)->findOneBy(['id' => $u_id]);
        $userEntity->setAccountstatus(['IN_ACTIVE']);
        $em->persist($userEntity);
        $em->flush();
        $postData = $em->getRepository(User::class)->DeleteUsers($u_id);

        if($postData){
            return new JsonResponse([
                'success' => 'ok',
                'code'    => '200',
                'message' => '',
            ]);
        }else{
            return new JsonResponse([
                'success' => 'Fail',
                'code'    => '500',
                'message' => '',
            ]);
        }

    }
}
