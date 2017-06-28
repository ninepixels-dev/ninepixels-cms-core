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

    public function deleteUserAction($id) {
        $userManager = $this->get('fos_user.user_manager');

        $user = $userManager->findUserBy(array('id' => $id));
        $user->setEnabled(false);

        $this->getBaseManager()
                ->logAction('User ' . $user->getUsername() . ' deactivated', $this->getLoggedUser());

        $userManager->updateUser($user);

        $view = array(
            'status' => 200,
            'item' => $user,
            'message' => 'User succesfully deleted'
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
