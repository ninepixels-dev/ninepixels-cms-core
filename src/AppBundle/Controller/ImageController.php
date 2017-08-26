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
                ->getAll('AppBundle:Image');

        return $this->handleView($this->view($view));
    }

    /**
     * Path: /images/{id}
     * Method: GET
     */
    public function getImageAction($id) {
        $view = $this->getBaseManager()
                ->get('AppBundle:Image', $id);

        return $this->handleView($this->view($view));
    }

    /**
     * Path: /galleries/{slug}/images
     * Method: GET
     */
    public function getGalleriesImagesAction($slug) {
        $param = array('gallery' => $slug === '0' ? NULL : $slug);

        $view = $this->getBaseManager()
                ->getBy('AppBundle:Image', $param);

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
                        ->getOneBy('AppBundle:Gallery', $data['gallery']) : false;

        if (!empty($file)) {
            $data = array_merge($data, $file);
        }

        $view = $this->getBaseManager()
                ->set($image, 'AppBundle:Image', $data, $this->getLoggedUser(), $request->getClientIp());

        return $this->handleView($this->view($view));
    }

    /**
     * Path: /images/{id}
     * Method: PUT
     */
    public function putImagesAction($id, Request $request) {
        $data = $request->request->all();

        isset($data['gallery']) ? $data['gallery'] = $this->getBaseManager()
                        ->getOneBy('AppBundle:Gallery', $data['gallery']['id']) : false;

        $view = $this->getBaseManager()
                ->update($data, 'AppBundle:Image', $id, $this->getLoggedUser(), $request->getClientIp());

        return $this->handleView($this->view($view));
    }

    /**
     * Path: /images/{id}
     * Method: DELETE
     */
    public function deleteImageAction($id, Request $request) {
        $view = $this->getBaseManager()
                ->delete('AppBundle:Image', $id, $this->getLoggedUser(), $request->getClientIp());

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
