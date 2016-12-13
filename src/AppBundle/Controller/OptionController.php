<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Option;
use FOS\RestBundle\Controller\FOSRestController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;

class OptionController extends FOSRestController {

    /**
     * Get all options
     * 
     * Path: /options
     * Method; GET
     * 
     * @return {json} List of options
     * 
     * @throws NotFoundHttpException when there is no options in database
     */
    public function getOptionsAction() {
        $item = $this->getBaseManager()
                ->getAllWithoutAuth('AppBundle:Option');

        if (!$item) {
            throw new HttpException(204, "There is no option for particular user");
        }

        return $this->handleView($this->view($item));
    }

    /**
     * Get specific option requested by ID
     * 
     * Path: /options/{id}
     * Method: GET
     * 
     * @param {int} $id Option identifier
     * @return {json} Option requested by ID
     * 
     * @throws NotFoundHttpException when requested option doesn't exist
     */
    public function getOptionAction($id) {
        $item = $this->getBaseManager()
                ->getWithoutAuth('AppBundle:Option', $id);

        if (!$item) {
            throw new HttpException(404, "Option not exist!");
        }

        return $this->handleView($this->view($item));
    }

    /**
     * Add new option in database
     * 
     * Path: /options
     * Method: POST
     * 
     * @param {obj} $request Request object
     * @return {json} Status
     * 
     */
    public function postOptionAction(Request $request) {
        $data = $request->request->all();
        $item = new Option();

        $result = $this->getBaseManager()
                ->set($item, $data, $this->getLoggedUser());

        $view = array(
            'status' => 201,
            'item' => $result,
            'message' => 'New option added to database!'
        );

        return $this->handleView($this->view($view));
    }

    /**
     * Update specific option
     * 
     * Path: /options/{id}
     * Method: PUT
     * 
     * @param {int} $id Item identifier
     * @param {obj} $request Request object
     * @return {json} Status
     * 
     * @throws NotFoundHttpException when requested option doesn't exist
     * @throws AccessDeniedException when user missmatch one defined in case
     */
    public function putOptionAction($id, Request $request) {
        $data = $request->request->all();

        $result = $this->getBaseManager()
                ->update($data, 'AppBundle:Option', $id, $this->getLoggedUser());

        if ($result === 404) {
            throw new HttpException(404, "Option with id " . $id . " not found!");
        } else if ($result === 401) {
            throw new AccessDeniedException();
        }

        $view = array(
            'status' => 200,
            'item' => $result,
            'message' => 'Option updated!'
        );

        return $this->handleView($this->view($view));
    }

    /**
     * Delete specific option
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
    public function deleteOptionAction($id) {
        $result = $this->getBaseManager()
                ->delete('AppBundle:Option', $id, $this->getLoggedUser());

        if ($result === 404) {
            throw new HttpException(404, "Option with id " . $id . " not found!");
        } else if ($result === 401) {
            throw new AccessDeniedException();
        }

        $view = array(
            'status' => 200,
            'message' => 'Option successfully deleted!'
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
