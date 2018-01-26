<?php

namespace AppBundle\Controller;

use FOS\RestBundle\Controller\FOSRestController;
use Symfony\Component\HttpFoundation\Request;

class AssetController extends FOSRestController {

    /**
     * Path: /assets
     * Method: GET
     */
    public function getAssetsAction() {
        $view = array(
            'pages' => $this->getBaseManager()->getAll('AppBundle:Page', true) ?: array(),
            'blogs' => $this->getBaseManager()->getAll('AppBundle:Blog', true) ?: array(),
            'travels' => $this->getBaseManager()->getAll('AppBundle:Travel', true) ?: array(),
            'products' => $this->getBaseManager()->getAll('AppBundle:Product', true) ?: array(),
            'events' => $this->getBaseManager()->getAll('AppBundle:Event', true) ?: array(),
            'languages' => $this->getBaseManager()->getAll('AppBundle:Language', true) ?: array(),
            'locales' => $this->getBaseManager()->getAll('AppBundle:Locale', true) ?: array(),
            'options' => $this->getBaseManager()->getAll('AppBundle:Option', true) ?: array(),
            'metadatas' => $this->getBaseManager()->getAll('AppBundle:Metadata', true) ?: array()
        );

        return $this->handleView($this->view($view));
    }

    /**
     * Initialize BaseManager
     */
    protected function getBaseManager() {
        return $this->get('app.base_manager');
    }

}
