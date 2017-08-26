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
    public function getBlogsAction(Request $request) {
        $view = $this->getBaseManager()
                ->getBy('AppBundle:Blog', $request->query->all(), false, array('created' => 'DESC'));

        return $this->handleView($this->view($view));
    }

    /**
     * Path: /blogs/{id}
     * Method: GET
     */
    public function getBlogAction($id) {
        $view = $this->getBaseManager()
                ->get('AppBundle:Blog', $id);

        return $this->handleView($this->view($view));
    }

    /**
     * Path: /pages/{id}/blogs
     * Method: GET
     */
    public function getPagesBlogsAction($page, Request $request) {
        $query = array_merge(array('page' => $page), (array) $request->query->all());

        $view = $this->getBaseManager()
                ->getBy('AppBundle:Blog', $query, false, array('created' => 'DESC'));

        return $this->handleView($this->view($view));
    }

    /**
     * Path: /blogs
     * Method: POST
     * 
     */
    public function postBlogAction(Request $request) {
        $item = new Blog();
        $item->setCreated(new \DateTime());

        $data = $request->request->all();

        isset($data['page']) ? $data['page'] = $this->getBaseManager()
                        ->getOneBy('AppBundle:Page', $data['page']['id']) : false;

        isset($data['image']) ? $data['image'] = $this->getBaseManager()
                        ->getOneBy('AppBundle:Image', $data['image']['id']) : false;

        // Set Author
        $data['author'] = $this->getLoggedUser()->getName();

        $view = $this->getBaseManager()
                ->set($item, 'AppBundle:Blog', $data, $this->getLoggedUser(), $request->getClientIp());

        return $this->handleView($this->view($view));
    }

    /**
     * Path: /blogs/{id}
     * Method: PUT
     */
    public function putBlogAction($id, Request $request) {
        $data = $request->request->all();
        $data['edited'] = new \DateTime();

        unset($data['created']);

        isset($data['page']) ? $data['page'] = $this->getBaseManager()
                        ->getOneBy('AppBundle:Page', $data['page']['id']) : false;

        isset($data['image']) ? $data['image'] = $this->getBaseManager()
                        ->getOneBy('AppBundle:Image', $data['image']['id']) : $data['image'] = NULL;

        $view = $this->getBaseManager()
                ->update($data, 'AppBundle:Blog', $id, $this->getLoggedUser(), $request->getClientIp());

        return $this->handleView($this->view($view));
    }

    /**
     * Path: /blogs/{id}
     * Method: DELETE
     */
    public function deleteBlogAction($id, Request $request) {
        $view = $this->getBaseManager()
                ->delete('AppBundle:Blog', $id, $this->getLoggedUser(), $request->getClientIp());

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
