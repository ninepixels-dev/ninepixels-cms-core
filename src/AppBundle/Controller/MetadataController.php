<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Metadata;
use FOS\RestBundle\Controller\FOSRestController;
use Symfony\Component\HttpFoundation\Request;

class MetadataController extends FOSRestController {

    /**
     * Path: /metadatas
     * Method: GET
     */
    public function getMetadatasAction() {
        $view = $this->getBaseManager()
                ->getAllWithoutAuth('AppBundle:Metadata');

        return $this->handleView($this->view($view));
    }

    /**
     * Path: /metadatas/{id}
     * Method: GET
     */
    public function getMetadataAction($id) {
        $view = $this->getBaseManager()
                ->getWithoutAuth('AppBundle:Metadata', $id);

        return $this->handleView($this->view($view));
    }

    /**
     * Path: /pages{page}/metadatas
     * Method: GET
     */
    public function getPagesMetadatasAction($page) {
        $view = $this->getBaseManager()
                ->getOneByWithoutAuth('AppBundle:Metadata', array('page' => $page, 'language' => NULL));

        return $this->handleView($this->view($view));
    }

    /**
     * Path: /languages/{lang}/pages{page}/metadatas
     * Method: GET
     */
    public function getLanguagesPagesMetadatasAction($lang, $page) {
        $view = $this->getBaseManager()
                ->getOneByWithoutAuth('AppBundle:Metadata', array('page' => $page, 'language' => $lang));

        return $this->handleView($this->view($view));
    }

    /**
     * Path: /metadatas
     * Method: POST
     */
    public function postMetadataAction(Request $request) {
        $item = new Metadata();
        $data = $request->request->all();

        isset($data['language']) ? $data['language'] = $this->getBaseManager()
                        ->getOneBy('AppBundle:Language', array('code' => $data['language']), $this->getLoggedUser()) : false;

        $view = $this->getBaseManager()
                ->set('AppBundle:Metadata', $item, $data, $this->getLoggedUser());

        return $this->handleView($this->view($view));
    }

    /**
     * Path: /metadatas/{id}
     * Method: PUT
     */
    public function putMetadataAction($id, Request $request) {
        $data = $request->request->all();

        isset($data['language']) ? $data['language'] = $this->getBaseManager()
                        ->getOneBy('AppBundle:Language', array('code' => $data['language']), $this->getLoggedUser()) : false;

        $view = $this->getBaseManager()
                ->update($data, 'AppBundle:Metadata', $id, $this->getLoggedUser());

        return $this->handleView($this->view($view));
    }

    /**
     * Path: /metadatas/{id}
     * Method: DELETE
     */
    public function deleteMetadataAction($id) {
        $view = $this->getBaseManager()
                ->delete('AppBundle:Metadata', $id, $this->getLoggedUser());

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
