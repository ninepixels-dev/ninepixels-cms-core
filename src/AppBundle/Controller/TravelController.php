<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Travel;
use FOS\RestBundle\Controller\FOSRestController;
use Symfony\Component\HttpFoundation\Request;

class TravelController extends FOSRestController {

    /**
     * Path: /travels
     * Method: GET
     */
    public function getTravelsAction(Request $request) {
        $query = (array) $request->query->all();

        $view = $this->getBaseManager()
                ->getBy('AppBundle:Travel', $query);

        return $this->handleView($this->view($view));
    }

    /**
     * Path: /travels/{id}
     * Method: GET
     */
    public function getTravelAction($id) {
        $view = $this->getBaseManager()
                ->get('AppBundle:Travel', $id);

        return $this->handleView($this->view($view));
    }

    /**
     * Path: /pages/{id}/travels
     * Method: GET
     */
    public function getPagesTravelsAction($page, Request $request) {
        $query = array_merge(array('page' => $page), (array) $request->query->all());

        $view = $this->getBaseManager()
                ->getBy('AppBundle:Travel', $query);

        return $this->handleView($this->view($view));
    }

    /**
     * Path: /travels
     * Method: POST
     * 
     */
    public function postTravelAction(Request $request) {
        $travel = new Travel();
        $data = $request->request->all();

        isset($data['page']) ? $data['page'] = $this->getBaseManager()
                        ->getOneBy('AppBundle:Page', $data['page']['id']) : false;

        isset($data['image']) ? $data['image'] = $this->getBaseManager()
                        ->getOneBy('AppBundle:Image', $data['image']['id']) : false;

        isset($data['gallery']) ? $data['gallery'] = $this->getBaseManager()
                        ->getOneBy('AppBundle:Gallery', $data['gallery']['id']) : false;

        $view = $this->getBaseManager()
                ->set($travel, 'AppBundle:Travel', $data, $this->getLoggedUser(), $request->getClientIp());

        return $this->handleView($this->view($view));
    }

    /**
     * Path: /travels/{id}
     * Method: PUT
     */
    public function putBlogAction($id, Request $request) {
        $data = $request->request->all();

        isset($data['page']) ? $data['page'] = $this->getBaseManager()
                        ->getOneBy('AppBundle:Page', $data['page']['id']) : false;

        isset($data['image']) ? $data['image'] = $this->getBaseManager()
                        ->getOneBy('AppBundle:Image', $data['image']['id']) : $data['image'] = NULL;

        isset($data['gallery']) ? $data['gallery'] = $this->getBaseManager()
                        ->getOneBy('AppBundle:Gallery', $data['gallery']['id']) : $data['gallery'] = NULL;

        $view = $this->getBaseManager()
                ->update($data, 'AppBundle:Travel', $id, $this->getLoggedUser(), $request->getClientIp());

        return $this->handleView($this->view($view));
    }

    /**
     * Path: /travels/{id}
     * Method: DELETE
     */
    public function deleteBlogAction($id, Request $request) {
        $view = $this->getBaseManager()
                ->delete('AppBundle:Travel', $id, $this->getLoggedUser(), $request->getClientIp());

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
