<?php

namespace App\Controller;

use App\Entity\Post;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Security\Core\Exception\BadCredentialsException;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use App\Entity\User;
use App\Security\JwtAuthenticator;
use Symfony\Component\Security\Core\User\UserProviderInterface;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use Lexik\Bundle\JWTAuthenticationBundle\Encoder\JWTEncoderInterface;
use Zend\Code\Reflection\DocBlock\Tag\ReturnTag;

class LoginController extends Controller
{
    public function __construct(JwtAuthenticator $jwtEncoder,JWTEncoderInterface $jwtEncoderIn)
    {
        $this->jwtEncoder = $jwtEncoder;
        $this->jwtEncoderIn = $jwtEncoderIn;
    }
    /**
     * @Route("/api/token", name="token_authentication")
     * @Method("POST")
     */
    public function newTokenAction(Request $request): JsonResponse
    {
        $username = $request->request->get('username');
        $user = $this->getDoctrine()->getRepository(User::class)->findOneBy(['username' => $username]);
        if (!$user) {
            throw $this->createNotFoundException();
        }
        // $role = $user->getRoles();
        // $use = new User();
        // if(in_array('ROLE_USER',$role)){
        //    $uu = $this->roleUser();
        // }else if($role == 'ROLE_ADMIN'){

        // }
        $password = $request->request->get('password');
        $isValid = $this->get('security.password_encoder')
            ->isPasswordValid($user, $password);

        if (!$isValid) {
            throw new BadCredentialsException();
        }

        $token = $this->get('lexik_jwt_authentication.encoder')
            ->encode([
                'username' => $user->getUsername(),
                'exp' => time() + 3600 // 1 hour expiration
        ]);


        
        return new JsonResponse(['token' => $token]);
    }

    /**
     * This is the route the login form submits to.
     *
     * But, this will never be executed. Symfony will intercept this first
     * and handle the login automatically. See form_login in app/config/security.yml
     *
     * @Route("/api/login_check", name="security_login_check")
     */
    public function loginCheckAction()
    {
        throw new \Exception('This should never be reached!');
    }

    /**
     * @Route(path="/api/check_login", name="checklogin")
     * @Method("POST")
     */
    public function getUserToken(Request $request){
        try{
            $preAuthToken = $this->jwtEncoder->getCredentials($request);
            $data = $this->jwtEncoderIn->decode($preAuthToken);
            if ($data) {
                
            
            return new JsonResponse([
                'success' => $data,
                'code'    => '200',
                'message' => 'Authorized User',
            ], Response::HTTP_OK);
        }
        } catch (\Exception $exception) {

            return new JsonResponse([
                'success' => 'UnAuthorized User',
                'code'    => $exception->getCode(),
                'message' => $exception->getMessage(),
            ], Response::HTTP_SERVICE_UNAVAILABLE);
        }
    }

    public function roleUser(){
        $user = $this->getDoctrine()->getRepository(Post::class)->findByUsers();
        return $user;
    }

}
