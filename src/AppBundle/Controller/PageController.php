<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Page;
use FOS\RestBundle\Controller\FOSRestController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;

class PageController extends FOSRestController {

    /**
     * Get all pages from currently logged user
     * 
     * Path: /pages
     * Method; GET
     * 
     * @return {json} List of pages
     * 
     * @throws NotFoundHttpException when there is no page in database
     */
    public function getPagesAction() {
        $page = $this->getBaseManager()
                ->getAllWithoutAuth('AppBundle:Page');

        if (!$page) {
            throw new HttpException(204, "There is no pages for particular user");
        }

        return $this->handleView($this->view($page));
    }

    /**
     * Get all child pages from page
     * 
     * Path: /pages/{id}/
     * Method; GET
     * 
     * @return {json} List of pages
     * 
     * @throws NotFoundHttpException when there is no page in database
     */
    public function getPagesChildAction($slug) {
        $page = $this->getBaseManager()
                ->getByWithoutAuth('AppBundle:Page', array('parent' => $slug));

        if (!$page) {
            throw new HttpException(204, "There is no child pages for particular page");
        }

        return $this->handleView($this->view($page));
    }

    /**
     * Get specific page requested by ID
     * 
     * Path: /pages/{id}
     * Method: GET
     * 
     * @param {int} $id Page identifier
     * @return {json} Page requested by ID
     * 
     * @throws NotFoundHttpException when requested page doesn't exist
     */
    public function getPageAction($id) {
        $page = $this->getBaseManager()
                ->getWithoutAuth('AppBundle:Page', $id);

        if (!$page) {
            throw new HttpException(404, "Page not exist!");
        }

        return $this->handleView($this->view($page));
    }

    /**
     * Add new page in database
     * 
     * Path: /pages
     * Method: POST
     * 
     * @param {obj} $request Request object
     * @return {json} Status
     * 
     */
    public function postPageAction(Request $request) {
        $data = $request->request->all();
        $page = new Page();

        if (isset($data['parent'])) {
            $data['parent'] = $this->getBaseManager()
                    ->get('AppBundle:Page', $data['parent'], $this->getLoggedUser());
        }

        if (isset($data['image'])) {
            $data['image'] = $this->getBaseManager()
                    ->get('AppBundle:Image', $data['image'], $this->getLoggedUser());
        }

        if (isset($data['gallery'])) {
            $data['gallery'] = $this->getBaseManager()
                    ->get('AppBundle:Gallery', $data['gallery'], $this->getLoggedUser());
        }

        $result = $this->getBaseManager()
                ->set($page, $data, $this->getLoggedUser());

        $view = array(
            'status' => 201,
            'item' => $result,
            'message' => 'New page added to database!'
        );

        return $this->handleView($this->view($view));
    }

    /**
     * Update specific page
     * 
     * Path: /pages/{id}
     * Method: PUT
     * 
     * @param {int} $id Page identifier
     * @param {obj} $request Request object
     * @return {json} Status
     * 
     * @throws NotFoundHttpException when requested page doesn't exist
     * @throws AccessDeniedException when user missmatch one defined in case
     */
    public function putPageAction($id, Request $request) {
        $data = $request->request->all();

        if (isset($data['parent'])) {
            $data['parent'] = $this->getBaseManager()
                    ->get('AppBundle:Page', $data['parent'], $this->getLoggedUser());
        }

        if (isset($data['image'])) {
            $data['image'] = $this->getBaseManager()
                    ->get('AppBundle:Image', $data['image'], $this->getLoggedUser());
        } else {
            $data['image'] = NULL;
        }

        if (isset($data['gallery'])) {
            $data['gallery'] = $this->getBaseManager()
                    ->get('AppBundle:Gallery', $data['gallery'], $this->getLoggedUser());
        } else {
            $data['gallery'] = NULL;
        }

        $result = $this->getBaseManager()
                ->update($data, 'AppBundle:Page', $id, $this->getLoggedUser());

        if ($result === 404) {
            throw new HttpException(404, "Page with id " . $id . " not found!");
        } else if ($result === 401) {
            throw new AccessDeniedException();
        }

        $view = array(
            'status' => 200,
            'item' => $result,
            'message' => 'Page updated!'
        );

        return $this->handleView($this->view($view));
    }

    /**
     * Delete specific pages
     * 
     * Path: /pages/{id}
     * Method: DELETE
     * 
     * @param {int} $id Page identifier
     * @return {json} Status
     * 
     * @throws NotFoundHttpException when requested page doesn't exist
     * @throws AccessDeniedException when user missmatch one defined in calendar
     */
    public function deletePageAction($id) {
        $result = $this->getBaseManager()
                ->delete('AppBundle:Page', $id, $this->getLoggedUser());

        if ($result === 404) {
            throw new HttpException(404, "Page with id " . $id . " not found!");
        } else if ($result === 401) {
            throw new AccessDeniedException();
        }

        $view = array(
            'status' => 200,
            'message' => 'Page successfully deleted!'
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
