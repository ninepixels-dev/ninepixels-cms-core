<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Product;
use FOS\RestBundle\Controller\FOSRestController;
use Symfony\Component\HttpFoundation\Request;

class ProductController extends FOSRestController {

    /**
     * Path: /products
     * Method: GET
     */
    public function getProductsAction() {
        $view = $this->getBaseManager()
                ->getAllWithoutAuth('AppBundle:Product');

        return $this->handleView($this->view($view));
    }

    /**
     * Path: /products/{id}
     * Method: GET
     */
    public function getProductAction($id) {
        $view = $this->getBaseManager()
                ->getWithoutAuth('AppBundle:Product', $id);

        return $this->handleView($this->view($view));
    }

    /**
     * Path: /products
     * Method: POST
     */
    public function postProductAction(Request $request) {
        $item = new Product();
        $data = $request->request->all();

        isset($data['image']) ? $data['image'] = $this->getBaseManager()
                        ->get('AppBundle:Image', $data['image'], $this->getLoggedUser()) : false;

        $view = $this->getBaseManager()
                ->set('AppBundle:Product', $item, $data, $this->getLoggedUser());

        return $this->handleView($this->view($view));
    }

    /**
     * Path: /products/{id}
     * Method: PUT
     */
    public function putProductAction($id, Request $request) {
        $data = $request->request->all();

        isset($data['image']) ? $data['image'] = $this->getBaseManager()
                        ->get('AppBundle:Image', $data['image'], $this->getLoggedUser()) : $data['image'] = NULL;

        $view = $this->getBaseManager()
                ->update($data, 'AppBundle:Product', $id, $this->getLoggedUser());

        return $this->handleView($this->view($view));
    }

    /**
     * Path: /options/{id}
     * Method: DELETE
     */
    public function deleteProductAction($id) {
        $view = $this->getBaseManager()
                ->delete('AppBundle:Product', $id, $this->getLoggedUser());

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
