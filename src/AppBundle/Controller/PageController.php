<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Page;
use FOS\RestBundle\Controller\FOSRestController;
use Symfony\Component\HttpFoundation\Request;

class PageController extends FOSRestController {

    /**
     * Path: /pages
     * Method: GET
     */
    public function getPagesAction(Request $request) {
        $query = (array) $request->query->all();

        $view = $this->getBaseManager()
                ->getBy('AppBundle:Page', $query);
        
        return $this->handleView($this->view($view));
    }

    /**
     * Path: /pages/{id}/
     * Method: GET
     */
    public function getPagesChildAction($slug) {
        $view = $this->getBaseManager()
                ->getBy('AppBundle:Page', array('parent' => $slug));

        return $this->handleView($this->view($view));
    }

    /**
     * Path: /pages/{id}
     * Method: GET
     */
    public function getPageAction($id) {
        $view = $this->getBaseManager()
                ->get('AppBundle:Page', $id);

        return $this->handleView($this->view($view));
    }

    /**
     * Path: /pages
     * Method: POST
     */
    public function postPageAction(Request $request) {
        $page = new Page();
        $data = $request->request->all();

        isset($data['parent']) ? $data['parent'] = $this->getBaseManager()
                        ->getOneBy('AppBundle:Page', $data['parent']['id']) : false;

        isset($data['image']) ? $data['image'] = $this->getBaseManager()
                        ->getOneBy('AppBundle:Image', $data['image']['id']) : false;

        isset($data['gallery']) ? $data['gallery'] = $this->getBaseManager()
                        ->getOneBy('AppBundle:Gallery', $data['gallery']['id']) : false;

        $view = $this->getBaseManager()
                ->set($page, 'AppBundle:Page', $data, $this->getLoggedUser(), $request->getClientIp());

        return $this->handleView($this->view($view));
    }

    /**
     * Path: /pages/{id}
     * Method: PUT
     */
    public function putPageAction($id, Request $request) {
        $data = $request->request->all();

        isset($data['parent']) ? $data['parent'] = $this->getBaseManager()
                        ->getOneBy('AppBundle:Page', $data['parent']['id']) : false;

        isset($data['image']) ? $data['image'] = $this->getBaseManager()
                        ->getOneBy('AppBundle:Image', $data['image']['id']) : $data['image'] = NULL;

        isset($data['gallery']) ? $data['gallery'] = $this->getBaseManager()
                        ->getOneBy('AppBundle:Gallery', $data['gallery']['id']) : $data['gallery'] = NULL;

        $view = $this->getBaseManager()
                ->update($data, 'AppBundle:Page', $id, $this->getLoggedUser(), $request->getClientIp());

        return $this->handleView($this->view($view));
    }

    /**
     * Path: /pages/{id}
     * Method: DELETE
     */
    public function deletePageAction($id, Request $request) {
        $view = $this->getBaseManager()
                ->delete('AppBundle:Page', $id, $this->getLoggedUser(), $request->getClientIp());

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
