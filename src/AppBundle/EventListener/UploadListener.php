<?php

namespace AppBundle\EventListener;

use Vich\UploaderBundle\Event\Event;
use Symfony\Component\HttpFoundation\Request;

class UploadListener {

    private $liipImagineController;

    public function __construct($liipImagineController) {
        $this->liipImagineController = $liipImagineController;
    }

    public function onVichuploaderPostupload(Event $event) {
        $object = $event->getObject()->getFile()->getFilename();
        $this->liipImagineController->filterAction(new Request(), $object, 'thumbs');
        $this->liipImagineController->filterAction(new Request(), $object, 'gallery');
    }

}
