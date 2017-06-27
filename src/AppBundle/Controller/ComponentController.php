<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Component;
use FOS\RestBundle\Controller\FOSRestController;
use Symfony\Component\HttpFoundation\Request;

class ComponentController extends FOSRestController {

    /**
     * Path: /components
     * Method: GET
     */
    public function getComponentsAction() {
        $view = $this->getBaseManager()
                ->getAllWithoutAuth('AppBundle:Component');

        return $this->handleView($this->view($view));
    }

    /**
     * Path: /components/{id}
     * Method: GET
     */
    public function getComponentAction($id) {
        $view = $this->getBaseManager()
                ->getWithoutAuth('AppBundle:Component', $id);

        return $this->handleView($this->view($view));
    }

    /**
     * Path: /components
     * Method: POST
     */
    public function postComponentAction(Request $request) {
        $item = new Component();
        $data = $request->request->all();

        $view = $this->getBaseManager()
                ->set('AppBundle:Component', $item, $data, $this->getLoggedUser());

        return $this->handleView($this->view($view));
    }

    /**
     * Path: /components/{id}
     * Method: PUT
     */
    public function putComponentAction($id, Request $request) {
        $data = $request->request->all();

        $view = $this->getBaseManager()
                ->update($data, 'AppBundle:Component', $id, $this->getLoggedUser());

        return $this->handleView($this->view($view));
    }

    /**
     * Path: /components/{id}
     * Method: DELETE
     */
    public function deleteComponentAction($id) {
        $view = $this->getBaseManager()
                ->delete('AppBundle:Component', $id, $this->getLoggedUser());

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
