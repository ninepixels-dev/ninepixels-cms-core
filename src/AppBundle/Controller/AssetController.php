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
            'pages' => $this->getBaseManager()->getAssetWithoutAuth('AppBundle:Page') ?: array(),
            'blogs' => $this->getBaseManager()->getAssetWithoutAuth('AppBundle:Blog') ?: array(),
            'languages' => $this->getBaseManager()->getAssetWithoutAuth('AppBundle:Language') ?: array(),
            'locales' => $this->getBaseManager()->getAssetWithoutAuth('AppBundle:Locale') ?: array(),
            'options' => $this->getBaseManager()->getAssetWithoutAuth('AppBundle:Option') ?: array(),
            'metadatas' => $this->getBaseManager()->getAssetWithoutAuth('AppBundle:Metadata') ?: array()
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
