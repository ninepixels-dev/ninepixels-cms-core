<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Product;
use FOS\RestBundle\Controller\FOSRestController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;

class ProductController extends FOSRestController {

    /**
     * Get all products
     * 
     * Path: /products
     * Method; GET
     * 
     * @return {json} List of products
     * 
     * @throws NotFoundHttpException when there is no products in database
     */
    public function getProductsAction() {
        $item = $this->getBaseManager()
                ->getAllWithoutAuth('AppBundle:Product');

        if (!$item) {
            throw new HttpException(204, "There is no product for particular user");
        }

        return $this->handleView($this->view($item));
    }

    /**
     * Get specific product requested by ID
     * 
     * Path: /products/{id}
     * Method: GET
     * 
     * @param {int} $id Product identifier
     * @return {json} Product requested by ID
     * 
     * @throws NotFoundHttpException when requested product doesn't exist
     */
    public function getProductAction($id) {
        $item = $this->getBaseManager()
                ->getWithoutAuth('AppBundle:Product', $id);

        if (!$item) {
            throw new HttpException(404, "Product not exist!");
        }

        return $this->handleView($this->view($item));
    }

    /**
     * Add new product in database
     * 
     * Path: /products
     * Method: POST
     * 
     * @param {obj} $request Request object
     * @return {json} Status
     * 
     */
    public function postProductAction(Request $request) {
        $data = $request->request->all();
        $item = new Product();

        if (isset($data['image'])) {
            $data['image'] = $this->getBaseManager()
                    ->get('AppBundle:Image', $data['image'], $this->getLoggedUser());
        }

        $result = $this->getBaseManager()
                ->set($item, $data, $this->getLoggedUser());

        $view = array(
            'status' => 201,
            'item' => $result,
            'message' => 'New product added to database!'
        );

        return $this->handleView($this->view($view));
    }

    /**
     * Update specific product
     * 
     * Path: /products/{id}
     * Method: PUT
     * 
     * @param {int} $id Product identifier
     * @param {obj} $request Request object
     * @return {json} Status
     * 
     * @throws NotFoundHttpException when requested product doesn't exist
     * @throws AccessDeniedException when user missmatch one defined in case
     */
    public function putProductAction($id, Request $request) {
        $data = $request->request->all();

        if (isset($data['image'])) {
            $data['image'] = $this->getBaseManager()
                    ->get('AppBundle:Image', $data['image'], $this->getLoggedUser());
        } else {
            $data['image'] = NULL;
        }

        $result = $this->getBaseManager()
                ->update($data, 'AppBundle:Product', $id, $this->getLoggedUser());

        if ($result === 404) {
            throw new HttpException(404, "Product with id " . $id . " not found!");
        } else if ($result === 401) {
            throw new AccessDeniedException();
        }

        $view = array(
            'status' => 200,
            'item' => $result,
            'message' => 'Product updated!'
        );

        return $this->handleView($this->view($view));
    }

    /**
     * Delete specific product
     * 
     * Path: /options/{id}
     * Method: DELETE
     * 
     * @param {int} $id Option identifier
     * @return {json} Status
     * 
     * @throws NotFoundHttpException when requested option doesn't exist
     * @throws AccessDeniedException when user missmatch one defined in calendar
     */
    public function deleteProductAction($id) {
        $result = $this->getBaseManager()
                ->delete('AppBundle:Product', $id, $this->getLoggedUser());

        if ($result === 404) {
            throw new HttpException(404, "Product with id " . $id . " not found!");
        } else if ($result === 401) {
            throw new AccessDeniedException();
        }

        $view = array(
            'status' => 200,
            'message' => 'Product successfully deleted!'
        );

        return $this->handleView($this->view($view));
    }

    /**
     * Initialize BaseManager
     * 
     * @return AppBundle\Services\BaseManager
     */
    protected function getBaseManager() {
        return $this->get('app.base_manager');
    }

    /**
     * Get currently logged user
     * 
     * @return {obj} User
     */
    protected function getLoggedUser() {
        return $this->get('security.token_storage')->getToken()->getUser();
    }

}
