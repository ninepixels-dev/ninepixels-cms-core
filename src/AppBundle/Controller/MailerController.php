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

        $this->getBaseManager()
                ->logAction('Message sent to: ' . $data['to'] . '\nMail Body: ' . $data['body'], null, $request->getClientIp(), 'MAIL');

        $view = array(
            'status' => 200,
            'message' => 'Message sent'
        );

        return $this->handleView($this->view($view));
    }

    /**
     * Initialize BaseManager
     */
    protected function getBaseManager() {
        return $this->get('app.base_manager');
    }

    /**
     * Get currently logged user
     */
    protected function getLoggedUser() {
        return $this->get('security.token_storage')->getToken()->getUser();
    }

}
