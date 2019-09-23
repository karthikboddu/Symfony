<?php

namespace App\Controller;

use App\Repository\TagsRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Security\JwtAuthenticator;
use Lexik\Bundle\JWTAuthenticationBundle\Encoder\JWTEncoderInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Security\Core\Exception\BadCredentialsException;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Component\HttpKernel\Exception\HttpException;

class TagsController extends AbstractController
{
    /**
     * @Route("/tags", name="tags")
     */
    public function index()
    {
        return $this->render('tags/index.html.twig', [
            'controller_name' => 'TagsController',
        ]);
    }

    /**
     * @Route(path="/api/tags", name="gettags")
     * @Method("GET")
     */
    public function getAllPost(TagsRepository $tagsRepository){
        $data = $tagsRepository->findAll();
        
        return $data;
    }


}
