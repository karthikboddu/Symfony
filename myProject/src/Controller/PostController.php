<?php

namespace App\Controller;

use App\Entity\Post;
use App\Entity\Tags;
use App\Entity\User;
use App\Form\PostType;
use App\Repository\PostRepository;
use App\Repository\TagsRepository;
use App\Security\JwtAuthenticator;
use Lexik\Bundle\JWTAuthenticationBundle\Encoder\JWTEncoderInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Security\Core\Exception\BadCredentialsException;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Component\HttpKernel\Exception\HttpException;
class PostController extends AbstractController
{

    public function __construct(JwtAuthenticator $jwtEncoder,JWTEncoderInterface $jwtEncoderIn)
    {
        $this->jwtEncoder = $jwtEncoder;
        $this->jwtEncoderIn = $jwtEncoderIn;
    }
    
    /**
     * @Route("/post", name="post")
     */
    public function index()
    {
        return $this->render('post/index.html.twig', [
            'controller_name' => 'PostController',
        ]);
    }

     /**
     * @Route(path="/api/post", name="post")
     * @Method("POST")
     */
    public function postRegisterAction(Request $request): JsonResponse
    {
        if($this->jwtEncoder->supports($request)){

        
        $post = new Post();
        $form = $this->createForm(PostType::class, $post);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $preAuthToken = $this->jwtEncoder->getCredentials($request);
            $data = $this->jwtEncoderIn->decode($preAuthToken);
            $username = $data['username'];
            $em = $this->getDoctrine()->getManager();
        
            $user = $em->getRepository(User::class)->findOneBy(['username' => $username]);
            $post->setCreated(new \DateTime());
            $post->setPostuser($user);


            $em->persist($post);
            $em->flush();

            return new JsonResponse(['status' => 'ok','data'=>$data]);
        }
    }
        throw new HttpException(400, "Invalid data");
    }

    /**
     * @Route(path="/api/posts", name="posts")
     * @Method("GET")
     */
    public function getAllPost(PostRepository $postRepository){
        $data = $postRepository->findAll();
        
        return $data;
    }

    /**
     * @Route(path="/api/postById", name="postById")
     * @Method("POST")
     */
    public function getPostById(Request $request,PostRepository $postRepository){
        if($this->jwtEncoder->supports($request)){
            $preAuthToken = $this->jwtEncoder->getCredentials($request);
            $data = $this->jwtEncoderIn->decode($preAuthToken);
            $username = $data['username'];
            $em = $this->getDoctrine()->getManager();
            $user = $em->getRepository(User::class)->findOneBy(['username' => $username]);
            $userd = $em->getRepository(Post::class)->findBy(['postuser'=>$user->getId()]);
            
            return $userd;
        }
        return new JsonResponse(['status' => 'f']);
    }


    /**
     * @Route(path="/api/postByTag", name="postByTag")
     * @Method("POST")
     */
    public function getPostByTag(Request $request,TagsRepository $tagsRepository){
        if($this->jwtEncoder->supports($request)){
            $preAuthToken = $this->jwtEncoder->getCredentials($request);
            $data = $this->jwtEncoderIn->decode($preAuthToken);
            $username = $data['username'];
            $em = $this->getDoctrine()->getManager();
            $user = $em->getRepository(User::class)->findOneBy(['username' => $username]);
            $userd = $em->getRepository(Post::class)->findBy(['postuser'=>$user->getId(),'posttag'=>'1']);
            
            return $userd;
        }
        return new JsonResponse(['status' => 'f']);
    }
 

}
