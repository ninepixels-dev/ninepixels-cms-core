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
    public function getProductsAction(Request $request) {
        $query = (array) $request->query->all();

        $view = $this->getBaseManager()
                ->getBy('AppBundle:Product', $query);

        return $this->handleView($this->view($view));
    }

    /**
     * Path: /products/{id}
     * Method: GET
     */
    public function getProductAction($id) {
        $view = $this->getBaseManager()
                ->get('AppBundle:Product', $id);

        return $this->handleView($this->view($view));
    }

    /**
     * Path: /pages/{id}/products
     * Method: GET
     */
    public function getPagesProductsAction($page, Request $request) {
        $query = array_merge(array('page' => $page), (array) $request->query->all());

        $view = $this->getBaseManager()
                ->getBy('AppBundle:Product', $query);

        return $this->handleView($this->view($view));
    }

    /**
     * Path: /products
     * Method: POST
     * 
     */
    public function postProductAction(Request $request) {
        $product = new Product();
        $data = $request->request->all();

        isset($data['page']) ? $data['page'] = $this->getBaseManager()
                        ->getOneBy('AppBundle:Page', $data['page']['id']) : false;

        isset($data['image']) ? $data['image'] = $this->getBaseManager()
                        ->getOneBy('AppBundle:Image', $data['image']['id']) : false;

        isset($data['gallery']) ? $data['gallery'] = $this->getBaseManager()
                        ->getOneBy('AppBundle:Gallery', $data['gallery']['id']) : false;

        $view = $this->getBaseManager()
                ->set($product, 'AppBundle:Product', $data, $this->getLoggedUser(), $request->getClientIp());

        return $this->handleView($this->view($view));
    }

    /**
     * Path: /products/{id}
     * Method: PUT
     */
    public function putProductAction($id, Request $request) {
        $data = $request->request->all();

        isset($data['page']) ? $data['page'] = $this->getBaseManager()
                        ->getOneBy('AppBundle:Page', $data['page']['id']) : false;

        isset($data['image']) ? $data['image'] = $this->getBaseManager()
                        ->getOneBy('AppBundle:Image', $data['image']['id']) : $data['image'] = NULL;

        isset($data['gallery']) ? $data['gallery'] = $this->getBaseManager()
                        ->getOneBy('AppBundle:Gallery', $data['gallery']['id']) : $data['gallery'] = NULL;

        $view = $this->getBaseManager()
                ->update($data, 'AppBundle:Product', $id, $this->getLoggedUser(), $request->getClientIp());

        return $this->handleView($this->view($view));
    }

    /**
     * Path: /products/{id}
     * Method: DELETE
     */
    public function deleteProductAction($id, Request $request) {
        $view = $this->getBaseManager()
                ->delete('AppBundle:Product', $id, $this->getLoggedUser(), $request->getClientIp());

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
