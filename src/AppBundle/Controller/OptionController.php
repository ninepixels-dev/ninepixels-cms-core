<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Option;
use FOS\RestBundle\Controller\FOSRestController;
use Symfony\Component\HttpFoundation\Request;

class OptionController extends FOSRestController {

    /**
     * Path: /options
     * Method: GET
     */
    public function getOptionsAction() {
        $view = $this->getBaseManager()
                ->getAllWithoutAuth('AppBundle:Option');

        return $this->handleView($this->view($view));
    }

    /**
     * Path: /options/{id}
     * Method: GET
     */
    public function getOptionAction($id) {
        $view = $this->getBaseManager()
                ->getWithoutAuth('AppBundle:Option', $id);

        return $this->handleView($this->view($view));
    }

    /**
     * Path: /options
     * Method: POST
     */
    public function postOptionAction(Request $request) {
        $item = new Option();
        $data = $request->request->all();

        $view = $this->getBaseManager()
                ->set('AppBundle:Option', $item, $data, $this->getLoggedUser());

        return $this->handleView($this->view($view));
    }

    /**
     * Path: /options/{id}
     * Method: PUT
     */
    public function putOptionAction($id, Request $request) {
        $data = $request->request->all();

        $view = $this->getBaseManager()
                ->update($data, 'AppBundle:Option', $id, $this->getLoggedUser());

        return $this->handleView($this->view($view));
    }

    /**
     * Path: /options/{id}
     * Method: DELETE
     */
    public function deleteOptionAction($id) {
        $view = $this->getBaseManager()
                ->delete('AppBundle:Option', $id, $this->getLoggedUser());

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
