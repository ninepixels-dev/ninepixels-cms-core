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
    public function getPagesAction() {
        $view = $this->getBaseManager()
                ->getAllWithoutAuth('AppBundle:Page');

        return $this->handleView($this->view($view));
    }

    /**
     * Path: /pages/{id}/
     * Method: GET
     */
    public function getPagesChildAction($slug) {
        $view = $this->getBaseManager()
                ->getByWithoutAuth('AppBundle:Page', array('parent' => $slug));

        return $this->handleView($this->view($view));
    }

    /**
     * Path: /pages/{id}
     * Method: GET
     */
    public function getPageAction($id) {
        $view = $this->getBaseManager()
                ->getWithoutAuth('AppBundle:Page', $id);

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
                        ->get('AppBundle:Page', $data['parent'], $this->getLoggedUser()) : false;

        isset($data['image']) ? $data['image'] = $this->getBaseManager()
                        ->get('AppBundle:Image', $data['image'], $this->getLoggedUser()) : false;

        isset($data['gallery']) ? $data['gallery'] = $this->getBaseManager()
                        ->get('AppBundle:Gallery', $data['gallery'], $this->getLoggedUser()) : false;

        $view = $this->getBaseManager()
                ->set('AppBundle:Page', $page, $data, $this->getLoggedUser());

        return $this->handleView($this->view($view));
    }

    /**
     * Path: /pages/{id}
     * Method: PUT
     */
    public function putPageAction($id, Request $request) {
        $data = $request->request->all();

        isset($data['parent']) ? $data['parent'] = $this->getBaseManager()
                        ->get('AppBundle:Page', $data['parent'], $this->getLoggedUser()) : false;

        isset($data['image']) ? $data['image'] = $this->getBaseManager()
                        ->get('AppBundle:Image', $data['image'], $this->getLoggedUser()) : $data['image'] = NULL;

        isset($data['gallery']) ? $data['gallery'] = $this->getBaseManager()
                        ->get('AppBundle:Gallery', $data['gallery'], $this->getLoggedUser()) : $data['gallery'] = NULL;

        $view = $this->getBaseManager()
                ->update($data, 'AppBundle:Page', $id, $this->getLoggedUser());

        return $this->handleView($this->view($view));
    }

    /**
     * Path: /pages/{id}
     * Method: DELETE
     */
    public function deletePageAction($id) {
        $view = $this->getBaseManager()
                ->delete('AppBundle:Page', $id, $this->getLoggedUser());

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
