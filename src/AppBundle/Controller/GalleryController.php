<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Gallery;
use FOS\RestBundle\Controller\FOSRestController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;

class GalleryController extends FOSRestController {

    /**
     * Get all galleries
     * 
     * Path: /options
     * Method; GET
     * 
     * @return {json} List of options
     * 
     * @throws NotFoundHttpException when there is no options in database
     */
    public function getGalleriesAction() {
        $item = $this->getBaseManager()
                ->getAllWithoutAuth('AppBundle:Gallery');

        if (!$item) {
            throw new HttpException(204, "There is no gallery for particular user");
        }

        return $this->handleView($this->view($item));
    }

    /**
     * Get specific gallery requested by ID
     * 
     * Path: /galleries/{id}
     * Method: GET
     * 
     * @param {int} $id Gallery identifier
     * @return {json} Gallery requested by ID
     * 
     * @throws NotFoundHttpException when requested gallery doesn't exist
     */
    public function getGalleryAction($id) {
        $item = $this->getBaseManager()
                ->getWithoutAuth('AppBundle:Gallery', $id);

        if (!$item) {
            throw new HttpException(404, "Gallery not exist!");
        }

        return $this->handleView($this->view($item));
    }

    /**
     * Add new gallery in database
     * 
     * Path: /galleries
     * Method: POST
     * 
     * @param {obj} $request Request object
     * @return {json} Status
     * 
     */
    public function postGalleryAction(Request $request) {
        $data = $request->request->all();
        $item = new Gallery();

        $result = $this->getBaseManager()
                ->set($item, $data, $this->getLoggedUser());

        $view = array(
            'status' => 201,
            'item' => $result,
            'message' => 'New galery added to database!'
        );

        return $this->handleView($this->view($view));
    }

    /**
     * Update specific gallery
     * 
     * Path: /galleries/{id}
     * Method: PUT
     * 
     * @param {int} $id Item identifier
     * @param {obj} $request Request object
     * @return {json} Status
     * 
     * @throws NotFoundHttpException when requested option doesn't exist
     * @throws AccessDeniedException when user missmatch one defined in case
     */
    public function putGalleryAction($id, Request $request) {
        $data = $request->request->all();

        $result = $this->getBaseManager()
                ->update($data, 'AppBundle:Gallery', $id, $this->getLoggedUser());

        if ($result === 404) {
            throw new HttpException(404, "Gallery with id " . $id . " not found!");
        } else if ($result === 401) {
            throw new AccessDeniedException();
        }

        $view = array(
            'status' => 200,
            'item' => $result,
            'message' => 'Gallery updated!'
        );

        return $this->handleView($this->view($view));
    }

    /**
     * Delete specific gallery
     * 
     * Path: /galleries/{id}
     * Method: DELETE
     * 
     * @param {int} $id Gallery identifier
     * @return {json} Status
     * 
     * @throws NotFoundHttpException when requested option doesn't exist
     * @throws AccessDeniedException when user missmatch one defined in calendar
     */
    public function deleteGalleryAction($id) {
        $result = $this->getBaseManager()
                ->delete('AppBundle:Gallery', $id, $this->getLoggedUser());

        if ($result === 404) {
            throw new HttpException(404, "Gallery with id " . $id . " not found!");
        } else if ($result === 401) {
            throw new AccessDeniedException();
        }

        $view = array(
            'status' => 200,
            'message' => 'Gallery successfully deleted!'
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