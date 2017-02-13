<?php

namespace AppBundle\Controller;

use FOS\RestBundle\Controller\FOSRestController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;

class MailerController extends FOSRestController {

    public function sendmailAction(Request $request) {
        $data = $request->request->all();

        $message = \Swift_Message::newInstance()
                ->setSubject($data['subject'])
                ->setFrom($data['from'])
                ->setTo($data['to'])
                ->setBody($data['body']);

        $this->get('mailer')->send($message);

        return $this->handleView($this->view($data));
    }

}
