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

        $view = array(
            'status' => 200,
            'message' => 'Message sent'
        );

        return $this->handleView($this->view($view));
    }

    public function bookingAction(Request $request) {
        $data = $request->request->all();
        $reservation_id = uniqid();

        $message = \Swift_Message::newInstance()
                ->setSubject('Website - New Booking!')
                ->setFrom($data['from'])
                ->setTo($data['to'])
                ->setBody($this->renderView('Emails/booking.html.twig', array_merge($data['body'], array('reservation_id' => $reservation_id))), 'text/html');

        $this->get('mailer')->send($message);

        $confirmation = \Swift_Message::newInstance()
                ->setSubject('Request for booking received!')
                ->setFrom($data['from'])
                ->setTo($data['body']['email'])
                ->setBody($this->renderView('Emails/booking.confirmation.html.twig', array_merge($data['body'], array('reservation_id' => $reservation_id))), 'text/html');

        $this->get('mailer')->send($confirmation);

        $view = array(
            'status' => 200,
            'message' => 'Booking confirmation send'
        );

        return $this->handleView($this->view($view));
    }

}
