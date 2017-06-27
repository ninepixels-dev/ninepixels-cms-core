<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Item;
use FOS\RestBundle\Controller\FOSRestController;
use Symfony\Component\HttpFoundation\Request;

class ItemController extends FOSRestController {

    /**
     * Path: /items
     * Method: GET
     */
    public function getItemsAction() {
        $view = $this->getBaseManager()
                ->getByWithoutAuth('AppBundle:Item', array('language' => NULL));

        return $this->handleView($this->view($view));
    }

    /**
     * Path: /pages/{slug}/items
     * Method: GET
     */
    public function getPagesItemsAction($slug, Request $request) {
        $param = $slug === '0' ? array_merge(array('page' => NULL, 'language' => NULL), $request->query->all()) :
                array_merge(array('page' => $slug, 'language' => NULL), $request->query->all());

        $view = $this->getBaseManager()->getByWithoutAuth('AppBundle:Item', $param);

        return $this->handleView($this->view($view));
    }

    /**
     * Path: /languages/{slug}/items
     * Method: GET
     */
    public function getLanguagesItemsAction($slug) {
        $view = $this->getBaseManager()
                ->getByWithoutAuth('AppBundle:Item', array('language' => $slug));

        return $this->handleView($this->view($view));
    }

    /**
     * Path: /languages/{lang}/pages/{slug}/items
     * Method: GET
     */
    public function getLanguagesPagesItemsAction($lang, $slug) {
        $view = $this->getBaseManager()
                ->getByWithoutAuth('AppBundle:Item', array('page' => $slug, 'language' => $lang));

        return $this->handleView($this->view($view));
    }

    /**
     * Path: /items/{id}
     * Method: GET
     */
    public function getItemAction($id) {
        $view = $this->getBaseManager()
                ->getOneByWithoutAuth('AppBundle:Item', array('id' => $id, 'language' => NULL));

        return $this->handleView($this->view($view));
    }

    /**
     * Path: /items
     * Method: POST
     */
    public function postItemAction(Request $request) {
        $item = new Item();
        $item->setVisible(1);
        $data = $request->request->all();

        isset($data['page']) ? $data['page'] = $this->getBaseManager()
                        ->get('AppBundle:Page', $data['page'], $this->getLoggedUser()) : false;

        isset($data['language']) ? $data['language'] = $this->getBaseManager()
                        ->get('AppBundle:Language', $data['language'], $this->getLoggedUser()) : false;

        isset($data['image']) ? $data['image'] = $this->getBaseManager()
                        ->get('AppBundle:Image', $data['image'], $this->getLoggedUser()) : false;

        isset($data['gallery']) ? $data['gallery'] = $this->getBaseManager()
                        ->get('AppBundle:Gallery', $data['gallery'], $this->getLoggedUser()) : false;

        $view = $this->getBaseManager()
                ->set('AppBundle:Item', $item, $data, $this->getLoggedUser());

        return $this->handleView($this->view($view));
    }

    /**
     * Path: /items/{id}
     * Method: PUT
     */
    public function putItemAction($id, Request $request) {
        $data = $request->request->all();

        isset($data['page']) ? $data['page'] = $this->getBaseManager()
                        ->get('AppBundle:Page', $data['page'], $this->getLoggedUser()) : false;

        isset($data['language']) ? $data['language'] = $this->getBaseManager()
                        ->get('AppBundle:Language', $data['language'], $this->getLoggedUser()) : false;

        isset($data['image']) ? $data['image'] = $this->getBaseManager()
                        ->get('AppBundle:Image', $data['image'], $this->getLoggedUser()) : $data['image'] = NULL;

        isset($data['gallery']) ? $data['gallery'] = $this->getBaseManager()
                        ->get('AppBundle:Gallery', $data['gallery'], $this->getLoggedUser()) : $data['gallery'] = NULL;

        $view = $this->getBaseManager()
                ->update($data, 'AppBundle:Item', $id, $this->getLoggedUser());

        return $this->handleView($this->view($view));
    }

    /**
     * Path: /items/{id}
     * Method: DELETE
     */
    public function deleteItemAction($id) {
        $view = $this->getBaseManager()
                ->delete('AppBundle:Item', $id, $this->getLoggedUser());

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
