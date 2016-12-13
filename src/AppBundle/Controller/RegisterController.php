<?php

namespace AppBundle\Controller;

use FOS\RestBundle\Controller\FOSRestController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpKernel\Exception\HttpException;

class RegisterController extends FOSRestController {

    public function registerAction(Request $request) {
        $userManager = $this->get('fos_user.user_manager');
        $data = $request->request->all();
        $token = random_bytes(64);

        if ($userManager->findUserByUsername($data['username'])) {
            throw new HttpException(400, "Usename alrady exist");
        }

        if ($userManager->findUserByEmail($data['email'])) {
            throw new HttpException(400, "Email already exist");
        }

        $user = $userManager->createUser();
        $user->setUsername($data['username']);
        $user->setEmail($data['email']);

        $user->setPlainPassword($data['password']);
        $user->setConfirmationToken(sha1($token));
        $user->setExpiresAt(
                new \DateTime(date('Y-m-d H:i:s', strtotime("+1 days")))
        );

        $userManager->updateUser($user);

        return $this->sendConfirmationEmail($user);
    }

    protected function sendConfirmationEmail($user) {
        $message = \Swift_Message::newInstance()
                ->setSubject('Registration on Ninepixels Seed Successful')
                ->setFrom('register@mojrokovnik.com')
                ->setTo($user->getEmail())
                ->setBody($this->renderView('Emails/registration.html.twig', array(
                    'name' => $user->getUsername(),
                    'confirmation_url' => 'register/confirm/' . $user->getConfirmationToken())
                ), 'text/html')
        ;

        $this->get('mailer')->send($message);

        return new JsonResponse('Mail to ' . $user->getEmail() . ' sent!');
    }

    public function confirmAction($token) {
        $userManager = $this->get('fos_user.user_manager');

        $user = $userManager->findUserByConfirmationToken($token);

        if (null === $user) {
            throw new HttpException(204, "The user with confirmation token does not exist");
        }

        $user->setConfirmationToken(null);
        $user->setExpiresAt(null);
        $user->setEnabled(true);

        $userManager->updateUser($user);

        return $this->redirect($this->getParameter('client_confirmation'));
    }

}
