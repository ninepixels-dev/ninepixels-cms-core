<?php

namespace AppBundle\Controller;

use FOS\RestBundle\Controller\FOSRestController;

class UserController extends FOSRestController {

    public function getUserAction() {
        $user = $this->get('security.token_storage')->getToken()->getUser();

        return $this->handleView($this->view($user));
    }
    
    public function getUsersAction() {
        $userManager = $this->get('fos_user.user_manager');
        $users = $userManager->findUsers();

        return $this->handleView($this->view($users));
    }
}
