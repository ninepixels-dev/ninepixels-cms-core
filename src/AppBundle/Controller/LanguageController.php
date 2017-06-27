<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Language;
use FOS\RestBundle\Controller\FOSRestController;
use Symfony\Component\HttpFoundation\Request;

class LanguageController extends FOSRestController {

    /**
     * Path: /languages
     * Method: GET
     */
    public function getLanguagesAction() {
        $view = $this->getBaseManager()
                ->getAllWithoutAuth('AppBundle:Language');

        return $this->handleView($this->view($view));
    }

    /**
     * Path: /languages/{id}
     * Method: GET
     */
    public function getLanguageAction($id) {
        $view = $this->getBaseManager()
                ->getWithoutAuth('AppBundle:Language', $id);

        return $this->handleView($this->view($view));
    }

    /**
     * Path: /languages
     * Method: POST
     */
    public function postLanguageAction(Request $request) {
        $item = new Language();
        $data = $request->request->all();

        $view = $this->getBaseManager()
                ->set('AppBundle:Language', $item, $data, $this->getLoggedUser());

        return $this->handleView($this->view($view));
    }

    /**
     * Path: /languages/{id}
     * Method: PUT
     */
    public function putLanguageAction($id, Request $request) {
        $data = $request->request->all();

        $view = $this->getBaseManager()
                ->update($data, 'AppBundle:Language', $id, $this->getLoggedUser());

        return $this->handleView($this->view($view));
    }

    /**
     * Path: /languages/{id}
     * Method: DELETE
     */
    public function deleteLanguageAction($id) {
        $view = $this->getBaseManager()
                ->delete('AppBundle:Language', $id, $this->getLoggedUser());

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
