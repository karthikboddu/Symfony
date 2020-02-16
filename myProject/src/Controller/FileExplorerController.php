<?php

namespace App\Controller;
use App\Entity\FileExplorer;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Lexik\Bundle\JWTAuthenticationBundle\Encoder\JWTEncoderInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\Exception\CustomUserMessageAuthenticationException;

class FileExplorerController extends AbstractController
{
    /**
     * @Route("/file/explorer", name="file_explorer")
     */
    public function index()
    {
        return $this->render('file_explorer/index.html.twig', [
            'controller_name' => 'FileExplorerController',
        ]);
    }

    /**
     * @Route("/api/file/addfile", name="file_add_file")
     */
    public function addFile(Request $request)
    {
        $name = $request->get('name');
        $isFolder = $request->get('isfolder');

    }

    /**
     * @Route("/api/file/getFileExp", name="file_get_file")
     */
    public function getFileExp(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $files = $em->getRepository(FileExplorer::class)->findAll();
        return $files;
    }
}
