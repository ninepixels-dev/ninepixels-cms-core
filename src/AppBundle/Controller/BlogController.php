<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Blog;
use FOS\RestBundle\Controller\FOSRestController;
use Symfony\Component\HttpFoundation\Request;

class BlogController extends FOSRestController {

    /**
     * Path: /blogs
     * Method: GET
     */
    public function getBlogsAction() {
        $view = $this->getBaseManager()
                ->getAllWithoutAuth('AppBundle:Blog');

        return $this->handleView($this->view($view));
    }

    /**
     * Path: /blogs/{id}
     * Method: GET
     */
    public function getBlogAction($id) {
        $view = $this->getBaseManager()
                ->getWithoutAuth('AppBundle:Blog', $id);

        return $this->handleView($this->view($view));
    }

    /**
     * Path: /blogs‚
     * Method: POST
     * 
     */
    public function postBlogAction(Request $request) {
        $item = new Blog();
        $item->setCreated(new \DateTime());

        $data = $request->request->all();
        isset($data['image']) ? $data['image'] = $this->getBaseManager()
                        ->get('AppBundle:Image', $data['image'], $this->getLoggedUser()) : false;

        $view = $this->getBaseManager()
                ->set($item, 'AppBundle:Blog', $data, $this->getLoggedUser());

        return $this->handleView($this->view($view));
    }

    /**
     * Path: /blogs/{id}
     * Method: PUT
     */
    public function putBlogAction($id, Request $request) {
        $data = $request->request->all();
        $data['edited'] = new \DateTime();

        isset($data['image']) ? $data['image'] = $this->getBaseManager()
                        ->get('AppBundle:Image', $data['image'], $this->getLoggedUser()) : $data['image'] = NULL;

        $view = $this->getBaseManager()
                ->update($data, 'AppBundle:Blog', $id, $this->getLoggedUser());

        return $this->handleView($this->view($view));
    }

    /**
     * Path: /blogs/{id}
     * Method: DELETE
     */
    public function deleteBlogAction($id) {
        $view = $this->getBaseManager()
                ->delete('AppBundle:Blog', $id, $this->getLoggedUser());

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
