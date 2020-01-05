<?php

namespace App\Controller;

use App\Entity\User;
use App\Event\EmailRegistrationUserEvent;
use App\Form\UserType;
use App\Service\UserServices;
use FOS\RestBundle\Controller\FOSRestController;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

class RegistrationController extends FOSRestController
{

    public function __construct(UserServices $userService)
    {
        $this->userService = $userService;
    }
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
                $password = $this->get('security.password_encoder')
                    ->encodePassword($user, $user->getPassword());
                if (!($this->userService->isUserExists($user))) {
                    $userId = $this->userService->insertUser($user, $password);
                    if ($userId) {
                        $event = new EmailRegistrationUserEvent($user);
                        $dispatcher = $this->get('event_dispatcher');
                        $dispatcher->dispatch(EmailRegistrationUserEvent::NAME, $event);
                        return new JsonResponse(['status' => '1', 'message' => 'OK']);
                    } else {
                        return new JsonResponse(['status' => '0', 'message' => 'FALSE']);
                    }
                }else{
                    return new JsonResponse(['status' => '0', 'message' => 'username already exits ']);
                }
            }

        } catch (\Exception $e) {
            return new JsonResponse([
                'status' => $e->getCode(),
                'message' => $e->getMessage(),
            ]);
        }
    }
}
