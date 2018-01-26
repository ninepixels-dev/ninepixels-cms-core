<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Gallery;
use FOS\RestBundle\Controller\FOSRestController;
use Symfony\Component\HttpFoundation\Request;

class GalleryController extends FOSRestController {

    /**
     * Path: /galleries
     * Method: GET
     */
    public function getGalleriesAction() {
        $view = $this->getBaseManager()
                ->getAll('AppBundle:Gallery');

        return $this->handleView($this->view($view));
    }

    /**
     * Path: /galleries/{id}
     * Method: GET
     */
    public function getGalleryAction($id) {
        $view = $this->getBaseManager()
                ->get('AppBundle:Gallery', $id);

        return $this->handleView($this->view($view));
    }

    /**
     * Path: /gallery/images
     * Method: GET
     */
    public function getGalleryImagesAction() {
        $view = array();
        $galleries = $this->getBaseManager()
                ->getAll('AppBundle:Gallery');

        foreach ($galleries as $gallery) {
            array_push($view, array(
                'id' => $gallery->getId(),
                'name' => $gallery->getName(),
                'images' => (array) $this->getBaseManager()
                        ->getBy('AppBundle:Image', array('gallery' => $gallery), true)
            ));
        }

        return $this->handleView($this->view($view));
    }

    /**
     * Path: /galleries
     * Method: POST
     */
    public function postGalleryAction(Request $request) {
        $item = new Gallery();
        $data = $request->request->all();

        isset($data['gallery']) ? $data['gallery'] = $this->getBaseManager()
                        ->getOneBy('AppBundle:Gallery', $data['gallery']['id']) : false;

        $view = $this->getBaseManager()
                ->set($item, 'AppBundle:Gallery', $data, $this->getLoggedUser(), $request->getClientIp());

        return $this->handleView($this->view($view));
    }

    /**
     * Path: /galleries/{id}
     * Method: PUT
     */
    public function putGalleryAction($id, Request $request) {
        $data = $request->request->all();

        isset($data['gallery']) ? $data['gallery'] = $this->getBaseManager()
                        ->getOneBy('AppBundle:Gallery', $data['gallery']['id']) : false;

        $view = $this->getBaseManager()
                ->update($data, 'AppBundle:Gallery', $id, $this->getLoggedUser(), $request->getClientIp());

        return $this->handleView($this->view($view));
    }

    /**
     * Path: /galleries/{id}
     * Method: DELETE
     */
    public function deleteGalleryAction($id, Request $request) {
        $view = $this->getBaseManager()
                ->delete('AppBundle:Gallery', $id, $this->getLoggedUser(), $request->getClientIp());

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
