<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Image;
use FOS\RestBundle\Controller\FOSRestController;
use Symfony\Component\HttpFoundation\Request;

class ImageController extends FOSRestController {

    /**
     * Path: /images
     * Method: GET
     */
    public function getImagesAction() {
        $view = $this->getBaseManager()
                ->getAllWithoutAuth('AppBundle:Image');

        return $this->handleView($this->view($view));
    }

    /**
     * Path: /images/{id}
     * Method: GET
     */
    public function getImageAction($id) {
        $view = $this->getBaseManager()
                ->getWithoutAuth('AppBundle:Image', $id);

        return $this->handleView($this->view($view));
    }

    /**
     * Path: /galleries/{slug}/images
     * Method: GET
     */
    public function getGalleriesImagesAction($slug) {
        $param = $slug === '0' ? array('gallery' => NULL) : array('gallery' => $slug);

        $view = $this->getBaseManager()
                ->getByWithoutAuth('AppBundle:Image', $param);

        return $this->handleView($this->view($view));
    }

    /**
     * Path: /images
     * Method: POST
     */
    public function postImagesAction(Request $request) {
        $image = new Image();
        $data = $request->request->all();
        $file = $request->files->all();

        isset($data['gallery']) ? $data['gallery'] = $this->getBaseManager()
                        ->get('AppBundle:Gallery', $data['gallery'], $this->getLoggedUser()) : false;

        if (!empty($file)) {
            $data = array_merge($data, $file);
        }

        $view = $this->getBaseManager()
                ->set('AppBundle:Gallery', $image, $data, $this->getLoggedUser());

        return $this->handleView($this->view($view));
    }

    /**
     * Path: /images/{id}
     * Method: PUT
     */
    public function putImagesAction($id, Request $request) {
        $data = $request->request->all();

        isset($data['gallery']) ? $data['gallery'] = $this->getBaseManager()
                        ->get('AppBundle:Gallery', $data['gallery'], $this->getLoggedUser()) : false;

        $view = $this->getBaseManager()
                ->update($data, 'AppBundle:Image', $id, $this->getLoggedUser());

        return $this->handleView($this->view($view));
    }

    /**
     * Path: /images/{id}
     * Method: DELETE
     */
    public function deleteImageAction($id) {
        $view = $this->getBaseManager()
                ->delete('AppBundle:Image', $id, $this->getLoggedUser());

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
