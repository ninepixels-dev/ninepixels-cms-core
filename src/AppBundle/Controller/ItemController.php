<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Item;
use FOS\RestBundle\Controller\FOSRestController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;

class ItemController extends FOSRestController {

    /**
     * Get all items from currently logged user
     * 
     * Path: /items
     * Method; GET
     * 
     * @return {json} List of items
     * 
     * @throws NotFoundHttpException when there is no item in database
     */
    public function getItemsAction() {
        $item = $this->getBaseManager()
                ->getAllWithoutAuth('AppBundle:Item');

        if (!$item) {
            throw new HttpException(204, "There is no items for particular user");
        }

        return $this->handleView($this->view($item));
    }

    /**
     * Get specific item requested by ID
     * 
     * Path: /items/{id}
     * Method: GET
     * 
     * @param {int} $id Item identifier
     * @return {json} Item requested by ID
     * 
     * @throws NotFoundHttpException when requested item doesn't exist
     */
    public function getItemAction($id) {
        $item = $this->getBaseManager()
                ->getWithoutAuth('AppBundle:Item', $id);

        if (!$item) {
            throw new HttpException(404, "Item not exist!");
        }

        return $this->handleView($this->view($item));
    }

    /**
     * Add new item in database
     * 
     * Path: /items
     * Method: POST
     * 
     * @param {obj} $request Request object
     * @return {json} Status
     * 
     */
    public function postItemAction(Request $request) {
        $data = $request->request->all();
        $item = new Item();

        $result = $this->getBaseManager()
                ->set($item, $data, $this->getLoggedUser());

        $view = array(
            'status' => 201,
            'item' => $result,
            'message' => 'New item added to database!'
        );

        return $this->handleView($this->view($view));
    }

    /**
     * Update specific item
     * 
     * Path: /items/{id}
     * Method: PUT
     * 
     * @param {int} $id Item identifier
     * @param {obj} $request Request object
     * @return {json} Status
     * 
     * @throws NotFoundHttpException when requested item doesn't exist
     * @throws AccessDeniedException when user missmatch one defined in case
     */
    public function putItemAction($id, Request $request) {
        $data = $request->request->all();

        $result = $this->getBaseManager()
                ->update($data, 'AppBundle:Item', $id, $this->getLoggedUser());

        if ($result === 404) {
            throw new HttpException(404, "Item with id " . $id . " not found!");
        } else if ($result === 401) {
            throw new AccessDeniedException();
        }

        $view = array(
            'status' => 200,
            'item' => $result,
            'message' => 'Item updated!'
        );

        return $this->handleView($this->view($view));
    }

    /**
     * Delete specific item
     * 
     * Path: /items/{id}
     * Method: DELETE
     * 
     * @param {int} $id Item identifier
     * @return {json} Status
     * 
     * @throws NotFoundHttpException when requested item doesn't exist
     * @throws AccessDeniedException when user missmatch one defined in calendar
     */
    public function deleteItemAction($id) {
        $result = $this->getBaseManager()
                ->delete('AppBundle:Item', $id, $this->getLoggedUser());

        if ($result === 404) {
            throw new HttpException(404, "Item with id " . $id . " not found!");
        } else if ($result === 401) {
            throw new AccessDeniedException();
        }

        $view = array(
            'status' => 200,
            'message' => 'Item successfully deleted!'
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
