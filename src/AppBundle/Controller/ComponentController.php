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
                ->getAll('AppBundle:Component');

        return $this->handleView($this->view($view));
    }

    /**
     * Path: /components/{id}
     * Method: GET
     */
    public function getComponentAction($id) {
        $view = $this->getBaseManager()
                ->get('AppBundle:Component', $id);

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
                ->set($item, 'AppBundle:Component', $data, $this->getLoggedUser(), $request->getClientIp());

        return $this->handleView($this->view($view));
    }

    /**
     * Path: /components/{id}
     * Method: PUT
     */
    public function putComponentAction($id, Request $request) {
        $data = $request->request->all();

        $view = $this->getBaseManager()
                ->update($data, 'AppBundle:Component', $id, $this->getLoggedUser(), $request->getClientIp());

        return $this->handleView($this->view($view));
    }

    /**
     * Path: /components/{id}
     * Method: DELETE
     */
    public function deleteComponentAction($id, Request $request) {
        $view = $this->getBaseManager()
                ->delete('AppBundle:Component', $id, $this->getLoggedUser(), $request->getClientIp());

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
