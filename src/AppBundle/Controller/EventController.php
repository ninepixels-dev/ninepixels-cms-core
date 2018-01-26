<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Event;
use FOS\RestBundle\Controller\FOSRestController;
use Symfony\Component\HttpFoundation\Request;

class EventController extends FOSRestController {

    /**
     * Path: /events
     * Method: GET
     */
    public function getEventsAction(Request $request) {
        $view = $this->getBaseManager()
                ->getBy('AppBundle:Event', $request->query->all(), false, array('created' => 'DESC'));

        return $this->handleView($this->view($view));
    }

    /**
     * Path: /events/{id}
     * Method: GET
     */
    public function getEventAction($id) {
        $view = $this->getBaseManager()
                ->get('AppBundle:Event', $id);

        return $this->handleView($this->view($view));
    }

    /**
     * Path: /pages/{id}/events
     * Method: GET
     */
    public function getPagesEventsAction($page, Request $request) {
        $query = array_merge(array('page' => $page), (array) $request->query->all());

        $view = $this->getBaseManager()
                ->getBy('AppBundle:Event', $query, false, array('created' => 'DESC'));

        return $this->handleView($this->view($view));
    }

    /**
     * Path: /languages/{slug}/events
     * Method: GET
     */
    public function getLanguagesEventsAction($slug) {
        $view = $this->getBaseManager()
                ->getBy('AppBundle:Event', array('language' => $slug), false, array('created' => 'DESC'));

        return $this->handleView($this->view($view));
    }

    /**
     * Path: /languages/{lang}/pages/{slug}/events
     * Method: GET
     */
    public function getLanguagesPagesEventsAction($lang, $slug) {
        $view = $this->getBaseManager()
                ->getBy('AppBundle:Event', array('page' => $slug, 'language' => $lang), false, array('created' => 'DESC'));

        return $this->handleView($this->view($view));
    }

    /**
     * Path: /events
     * Method: POST
     * 
     */
    public function postEventAction(Request $request) {
        $item = new Event();

        $data = $request->request->all();

        isset($data['page']) ? $data['page'] = $this->getBaseManager()
                        ->getOneBy('AppBundle:Page', $data['page']['id']) : false;

        isset($data['date_from']) ?
                        $data['date_from'] = new \DateTime($data['date_from']) : false;

        isset($data['date_to']) ?
                        $data['date_to'] = new \DateTime($data['date_to']) : false;

        $view = $this->getBaseManager()
                ->set($item, 'AppBundle:Event', $data, $this->getLoggedUser(), $request->getClientIp());

        return $this->handleView($this->view($view));
    }

    /**
     * Path: /events/{id}
     * Method: PUT
     */
    public function putEventAction($id, Request $request) {
        $data = $request->request->all();
        
        isset($data['page']) ? $data['page'] = $this->getBaseManager()
                        ->getOneBy('AppBundle:Page', $data['page']['id']) : false;
      
        isset($data['date_from']) ?
                        $data['date_from'] = new \DateTime($data['date_from']) : false;

        isset($data['date_to']) ?
                        $data['date_to'] = new \DateTime($data['date_to']) : false;
        
        $view = $this->getBaseManager()
                ->update($data, 'AppBundle:Event', $id, $this->getLoggedUser(), $request->getClientIp());

        return $this->handleView($this->view($view));
    }

    /**
     * Path: /events/{id}
     * Method: DELETE
     */
    public function deleteEventAction($id, Request $request) {
        $view = $this->getBaseManager()
                ->delete('AppBundle:Event', $id, $this->getLoggedUser(), $request->getClientIp());

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
