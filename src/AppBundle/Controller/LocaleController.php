<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Locale;
use FOS\RestBundle\Controller\FOSRestController;
use Symfony\Component\HttpFoundation\Request;

class LocaleController extends FOSRestController {

    /**
     * Path: /locales
     * Method: GET
     */
    public function getLocalesAction() {
        $view = $this->getBaseManager()
                ->getAllWithoutAuth('AppBundle:Locale');

        return $this->handleView($this->view($view));
    }

    /**
     * Path: /locales/{id}
     * Method: GET
     */
    public function getLocaleAction($id) {
        $view = $this->getBaseManager()
                ->getWithoutAuth('AppBundle:Locale', $id);

        return $this->handleView($this->view($view));
    }

    /**
     * Path: /locales
     * Method: POST
     */
    public function postLocaleAction(Request $request) {
        $item = new Locale();
        $data = $request->request->all();

        isset($data['language']) ? $data['language'] = $this->getBaseManager()
                        ->getOneBy('AppBundle:Language', array('code' => $data['language']), $this->getLoggedUser()) : false;

        $view = $this->getBaseManager()
                ->set('AppBundle:Locale', $item, $data, $this->getLoggedUser());

        return $this->handleView($this->view($view));
    }

    /**
     * Path: /locales/{id}
     * Method: PUT
     */
    public function putLocaleAction($id, Request $request) {
        $data = $request->request->all();

        isset($data['language']) ? $data['language'] = $this->getBaseManager()
                        ->getOneBy('AppBundle:Language', array('code' => $data['language']), $this->getLoggedUser()) : false;

        $view = $this->getBaseManager()
                ->update($data, 'AppBundle:Locale', $id, $this->getLoggedUser());

        return $this->handleView($this->view($view));
    }

    /**
     * Path: /locales/{id}
     * Method: DELETE
     */
    public function deleteLocaleAction($id) {
        $view = $this->getBaseManager()
                ->delete('AppBundle:Locale', $id, $this->getLoggedUser());

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
