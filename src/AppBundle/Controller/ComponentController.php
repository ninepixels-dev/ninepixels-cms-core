<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Component;
use FOS\RestBundle\Controller\FOSRestController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;

class ComponentController extends FOSRestController {

    /**
     * Get all components
     * 
     * Path: /components
     * Method; GET
     * 
     * @return {json} List of components
     * 
     * @throws NotFoundHttpException when there is no components in database
     */
    public function getComponentsAction() {
        $item = $this->getBaseManager()
                ->getAllWithoutAuth('AppBundle:Component');

        if (!$item) {
            throw new HttpException(204, "There is no component for particular user");
        }

        return $this->handleView($this->view($item));
    }

    /**
     * Get specific component requested by ID
     * 
     * Path: /components/{id}
     * Method: GET
     * 
     * @param {int} $id Component identifier
     * @return {json} Component requested by ID
     * 
     * @throws NotFoundHttpException when requested component doesn't exist
     */
    public function getComponentAction($id) {
        $item = $this->getBaseManager()
                ->getWithoutAuth('AppBundle:Component', $id);

        if (!$item) {
            throw new HttpException(404, "Component not exist!");
        }

        return $this->handleView($this->view($item));
    }

    /**
     * Add new component in database
     * 
     * Path: /components
     * Method: POST
     * 
     * @param {obj} $request Request component
     * @return {json} Status
     * 
     */
    public function postComponentAction(Request $request) {
        $data = $request->request->all();
        $item = new Component();

        $result = $this->getBaseManager()
                ->set($item, $data, $this->getLoggedUser());

        $view = array(
            'status' => 201,
            'item' => $result,
            'message' => 'New component added to database!'
        );

        return $this->handleView($this->view($view));
    }

    /**
     * Update specific component
     * 
     * Path: /components/{id}
     * Method: PUT
     * 
     * @param {int} $id Component identifier
     * @param {obj} $request Request object
     * @return {json} Status
     * 
     * @throws NotFoundHttpException when requested option doesn't exist
     * @throws AccessDeniedException when user missmatch one defined in case
     */
    public function putComponentAction($id, Request $request) {
        $data = $request->request->all();

        $result = $this->getBaseManager()
                ->update($data, 'AppBundle:Component', $id, $this->getLoggedUser());

        if ($result === 404) {
            throw new HttpException(404, "Component with id " . $id . " not found!");
        } else if ($result === 401) {
            throw new AccessDeniedException();
        }

        $view = array(
            'status' => 200,
            'item' => $result,
            'message' => 'Component updated!'
        );

        return $this->handleView($this->view($view));
    }

    /**
     * Delete specific component
     * 
     * Path: /components/{id}
     * Method: DELETE
     * 
     * @param {int} $id Component identifier
     * @return {json} Status
     * 
     * @throws NotFoundHttpException when requested component doesn't exist
     * @throws AccessDeniedException when user missmatch one defined in calendar
     */
    public function deleteComponentAction($id) {
        $result = $this->getBaseManager()
                ->delete('AppBundle:Component', $id, $this->getLoggedUser());

        if ($result === 404) {
            throw new HttpException(404, "Component with id " . $id . " not found!");
        } else if ($result === 401) {
            throw new AccessDeniedException();
        }

        $view = array(
            'status' => 200,
            'message' => 'Component successfully deleted!'
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
