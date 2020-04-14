<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\FileUpload;
use App\Entity\Post;
use App\Entity\Tags;
use App\Entity\UploadMediaType;
use App\Entity\User;
use App\Form\FileUploadType;
use App\Form\PostType;
use App\Repository\PostRepository;
use App\Repository\TagsRepository;
use App\Security\JwtAuthenticator;
use Aws\S3\S3Client;
use Cocur\Slugify\Slugify;
use Lexik\Bundle\JWTAuthenticationBundle\Encoder\JWTEncoderInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
//use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Symfony\Component\Security\Core\Exception\CustomUserMessageAuthenticationException;


class UploadController extends AbstractController
{

    public function __construct(JwtAuthenticator $jwtEncoder, JWTEncoderInterface $jwtEncoderIn)
    {
        $this->jwtEncoder = $jwtEncoder;
        $this->jwtEncoderIn = $jwtEncoderIn;

    }

    /**
     * @Route("/upload", name="upload")
     */
    public function index()
    {
        return $this->render('upload/index.html.twig', [
            'controller_name' => 'UploadController',
        ]);
    }
    
    /**
     * @Route("/api/getFileByUserId", name="getFileByUserId")
     */
    public function getFileByUserId(Request $request)
    {

        if ($this->jwtEncoder->supports($request)) {
        
            $preAuthToken = $this->jwtEncoder->getCredentials($request);
            $data = $this->jwtEncoderIn->decode($preAuthToken);
            $username = $data['username'];
            if ($data == false) {
                throw new CustomUserMessageAuthenticationException('Expired Token');
            } else {
                $em = $this->getDoctrine()->getManager();
                $user = $em->getRepository(User::class)->findOneBy(['username' => $username]);
                $userId = $user->getId();
                $user = $this->getDoctrine()->getRepository(User::class)->findByFileUserId($userId);
                return $user;            }

        }
    }
    
}
