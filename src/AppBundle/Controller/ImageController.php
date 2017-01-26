<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Image;
use FOS\RestBundle\Controller\FOSRestController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;

class ImageController extends FOSRestController {

    /**
     * Get all images from currently logged user
     * 
     * Path: /images
     * Method; GET
     * 
     * @return {json} List of images
     * 
     * @throws NotFoundHttpException when there is no gallery in database
     */
    public function getImagesAction() {
        $image = $this->getBaseManager()
                ->getAllWithoutAuth('AppBundle:Image');

        if (!$image) {
            throw new HttpException(204, "There is no images for particular user");
        }

        return $this->handleView($this->view($image));
    }

    /**
     * Get specific image requested by ID
     * 
     * Path: /images/{id}
     * Method: GET
     * 
     * @param {int} $id Image identifier
     * @return {json} Image requested by ID
     * 
     * @throws NotFoundHttpException when requested image doesn't exist
     */
    public function getImageAction($id) {
        $image = $this->getBaseManager()
                ->getWithoutAuth('AppBundle:Image', $id);

        if (!$image) {
            throw new HttpException(404, "Image not exist!");
        }

        return $this->handleView($this->view($image));
    }

    /**
     * Get all images from specific gallery
     * 
     * Path: /galleries/{slug}/images
     * Method; GET
     * 
     * @return {json} List of items
     * 
     * @throws NotFoundHttpException when there is no item in database
     */
    public function getGalleriesImagesAction($slug) {
        if ($slug === '0') {
            $item = $this->getBaseManager()
                    ->getByWithoutAuth('AppBundle:Image', array('gallery' => NULL));
        } else {
            $item = $this->getBaseManager()
                    ->getByWithoutAuth('AppBundle:Image', array('gallery' => $slug));
        }

        if (!$item) {
            throw new HttpException(204, "There is no images for particular gallery");
        }

        return $this->handleView($this->view($item));
    }

    /**
     * Add new image in database
     * 
     * Path: /images
     * Method: POST
     * 
     * @param {obj} $request Request object
     * @return {json} Status
     * 
     */
    public function postImagesAction(Request $request) {
        $data = $request->request->all();
        $file = $request->files->all();
        $image = new Image();

        if (isset($data['gallery'])) {
            $data['gallery'] = $this->getBaseManager()
                    ->get('AppBundle:Gallery', $data['gallery'], $this->getLoggedUser());
        }

        if (!empty($file)) {
            $data = array_merge($data, $file);
        }

        $result = $this->getBaseManager()
                ->set($image, $data, $this->getLoggedUser());

        $view = array(
            'status' => 201,
            'item' => $result,
            'message' => 'New image added to database!'
        );

        return $this->handleView($this->view($view));
    }

    /**
     * Update specific image
     * 
     * Path: /images/{id}
     * Method: PUT
     * 
     * @param {int} $id Image identifier
     * @param {obj} $request Request object
     * @return {json} Status
     * 
     * @throws NotFoundHttpException when requested image doesn't exist
     * @throws AccessDeniedException when user missmatch one defined in case
     */
    public function putImagesAction($id, Request $request) {
        $data = $request->request->all();

        if (isset($data['gallery'])) {
            $data['gallery'] = $this->getBaseManager()
                    ->get('AppBundle:Gallery', $data['gallery'], $this->getLoggedUser());
        }

        $result = $this->getBaseManager()
                ->update($data, 'AppBundle:Image', $id, $this->getLoggedUser());

        if ($result === 404) {
            throw new HttpException(404, "Image with id " . $id . " not found!");
        } else if ($result === 401) {
            throw new AccessDeniedException();
        }

        $view = array(
            'status' => 200,
            'item' => $result,
            'message' => 'Image updated!'
        );

        return $this->handleView($this->view($view));
    }

    /**
     * Delete specific image
     * 
     * Path: /images/{id}
     * Method: DELETE
     * 
     * @param {int} $id Image identifier
     * @return {json} Status
     * 
     * @throws NotFoundHttpException when requested image doesn't exist
     * @throws AccessDeniedException when user missmatch one defined in calendar
     */
    public function deleteImageAction($id) {
        $result = $this->getBaseManager()
                ->delete('AppBundle:Image', $id, $this->getLoggedUser());

        if ($result === 404) {
            throw new HttpException(404, "Image with id " . $id . " not found!");
        } else if ($result === 401) {
            throw new AccessDeniedException();
        }

        $view = array(
            'status' => 200,
            'message' => 'Image successfully deleted!'
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
