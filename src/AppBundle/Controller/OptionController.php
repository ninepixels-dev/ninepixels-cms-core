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
                ->getAll('AppBundle:Option');

        return $this->handleView($this->view($view));
    }

    /**
     * Path: /options/{id}
     * Method: GET
     */
    public function getOptionAction($id) {
        $view = $this->getBaseManager()
                ->get('AppBundle:Option', $id);

        return $this->handleView($this->view($view));
    }

    /**
     * Path: /options/{group}
     * Method: GET
     */
    public function getOptionGroupAction($group) {
        $view = $this->getBaseManager()
                ->getBy('AppBundle:Option', array('group' => $group));

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
                ->set($item, 'AppBundle:Option', $data, $this->getLoggedUser(), $request->getClientIp());

        return $this->handleView($this->view($view));
    }

    /**
     * Path: /options/{id}
     * Method: PUT
     */
    public function putOptionAction($id, Request $request) {
        $data = $request->request->all();

        $view = $this->getBaseManager()
                ->update($data, 'AppBundle:Option', $id, $this->getLoggedUser(), $request->getClientIp());

        return $this->handleView($this->view($view));
    }

    /**
     * Path: /options/{id}
     * Method: DELETE
     */
    public function deleteOptionAction($id, Request $request) {
        $view = $this->getBaseManager()
                ->delete('AppBundle:Option', $id, $this->getLoggedUser(), $request->getClientIp());

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
