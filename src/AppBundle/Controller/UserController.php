<?php

namespace AppBundle\Controller;

use FOS\RestBundle\Controller\FOSRestController;
use Symfony\Component\HttpFoundation\Request;

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

    public function postUserAction(Request $request) {
        $userManager = $this->get('fos_user.user_manager');
        $data = $request->request->all();
        $token = random_bytes(64);

        if ($userManager->findUserByUsername($data['username'])) {
            throw new HttpException(400, "Username alrady exist");
        }

        if ($userManager->findUserByEmail($data['email'])) {
            throw new HttpException(400, "Email already exist");
        }

        $user = $userManager->createUser();
        $user->setUsername($data['username']);
        $user->setEmail($data['email']);
        $user->setPlainPassword($data['password']);
        $user->setEnabled($data['enabled']);
        $user->addRole($data['admin'] === true ? 'ROLE_ADMIN' : 'ROLE_USER');

        $userManager->updateUser($user);

        $this->getBaseManager()
                ->logAction('User ' . $data['username'] . ' created', $this->getLoggedUser(), $request->getClientIp(), 'POST');

        $view = array(
            'status' => 201,
            'item' => $userManager->findUserByUsername($data['username']),
            'message' => 'New user added to database'
        );

        return $this->handleView($this->view($view));
    }

    public function putUserAction($id, Request $request) {
        $data = $request->request->all();

        $userManager = $this->get('fos_user.user_manager');

        $user = $userManager->findUserBy(array('id' => $id));

        $user->setUsername($data['username']);
        $user->setEmail($data['email']);

        if (isset($data['password'])) {
            $user->setPlainPassword($data['password']);
        }

        $user->setEnabled($data['enabled']);
        $user->addRole($data['admin'] === true ? 'ROLE_ADMIN' : 'ROLE_USER');

        $this->getBaseManager()
                ->logAction('User ' . $user->getUsername() . ($data['enabled'] === true ? ' updated' : 'deactivated'), $this->getLoggedUser(), $request->getClientIp(), 'PUT');

        $userManager->updateUser($user);

        $view = array(
            'status' => 200,
            'item' => $user,
            'message' => $data['enabled'] === true ? 'User succesfully updated' : 'User deactivated'
        );

        return $this->handleView($this->view($view));
    }

    public function deleteUserAction($id, Request $request) {
        $userManager = $this->get('fos_user.user_manager');

        $user = $userManager->findUserBy(array('id' => $id));
        $user->setEnabled(false);

        $userManager->deleteUser($user);

        $this->getBaseManager()
                ->logAction('User ' . $user->getUsername() . ' deleted', $this->getLoggedUser(), $request->getClientIp(), 'DELETE');

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
