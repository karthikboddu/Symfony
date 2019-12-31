<?php

namespace App\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use FOS\RestBundle\Controller\FOSRestController;
use Symfony\Component\HttpKernel\Exception\HttpException;
use App\Form\UserType;
use App\Entity\User;
use App\Entity\UserTypeMaster;
use App\Event\EmailRegistrationUserEvent;
use DateTimeInterface;

class RegistrationController extends FOSRestController
{
    /**
     * @Route(path="/api/register", name="registration")
     * @Method("POST")
     */
    public function postRegisterAction(Request $request): JsonResponse
    {
        try {
            $user = new User();
            $form = $this->createForm(UserType::class, $user);
            $form->handleRequest($request);

            if ($form->isValid()) {
                $em = $this->getDoctrine()->getManager();
                $password = $this->get('security.password_encoder')
                    ->encodePassword($user, $user->getPassword());
                $user->setPassword($password);
                $user->setRoles(['ROLE_USER']);
                $user->setAccountstatus(['IN_ACTIVE']);
                $user->setCreatedAt(new \DateTime());
                $user->setActive(true);
                $userType =  $em->getRepository(UserTypeMaster::class)->findOneBy(['name' => 'ROLE_USER']);
                $user->setFkUserType($userType);

                $event = new EmailRegistrationUserEvent($user);
                $dispatcher = $this->get('event_dispatcher');
                $dispatcher->dispatch(EmailRegistrationUserEvent::NAME, $event);

                $em->persist($user);
                $em->flush();
            }
            return new JsonResponse(['status' => '1', 'message' => 'ok']);
        } catch (\Exception $e) {
            return new JsonResponse([
                'status' => $e->getCode(),
                'message' => $e->getMessage(),
            ]);
        }
    }
}
