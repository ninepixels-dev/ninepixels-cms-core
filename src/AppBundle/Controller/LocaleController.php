<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Locale;
use FOS\RestBundle\Controller\FOSRestController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;

class LocaleController extends FOSRestController {

    /**
     * Get all locales
     * 
     * Path: /locales
     * Method; GET
     * 
     * @return {json} List of locales
     * 
     * @throws NotFoundHttpException when there is no locales in database
     */
    public function getLocalesAction() {
        $item = $this->getBaseManager()
                ->getAllWithoutAuth('AppBundle:Locale');

        if (!$item) {
            throw new HttpException(204, "There is no locale for particular user");
        }

        return $this->handleView($this->view($item));
    }

    /**
     * Get specific locale requested by ID
     * 
     * Path: /locales/{id}
     * Method: GET
     * 
     * @param {int} $id Locale identifier
     * @return {json} Locale requested by ID
     * 
     * @throws NotFoundHttpException when requested locale doesn't exist
     */
    public function getLocaleAction($id) {
        $item = $this->getBaseManager()
                ->getWithoutAuth('AppBundle:Locale', $id);

        if (!$item) {
            throw new HttpException(404, "Locale not exist!");
        }

        return $this->handleView($this->view($item));
    }

    /**
     * Add new locale in database
     * 
     * Path: /locales
     * Method: POST
     * 
     * @param {obj} $request Request object
     * @return {json} Status
     * 
     */
    public function postLocaleAction(Request $request) {
        $data = $request->request->all();
        $item = new Locale();

        if (isset($data['item'])) {
            $data['item'] = $this->getBaseManager()
                    ->get('AppBundle:Item', $data['item'], $this->getLoggedUser());
        }

        $result = $this->getBaseManager()
                ->set($item, $data, $this->getLoggedUser());

        $view = array(
            'status' => 201,
            'item' => $result,
            'message' => 'New locale added to database!'
        );

        return $this->handleView($this->view($view));
    }

    /**
     * Update specific locale
     * 
     * Path: /locales/{id}
     * Method: PUT
     * 
     * @param {int} $id Item identifier
     * @param {obj} $request Request object
     * @return {json} Status
     * 
     * @throws NotFoundHttpException when requested locale doesn't exist
     * @throws AccessDeniedException when user missmatch one defined in case
     */
    public function putLocaleAction($id, Request $request) {
        $data = $request->request->all();

        if (isset($data['item'])) {
            $data['item'] = $this->getBaseManager()
                    ->get('AppBundle:Item', $data['item'], $this->getLoggedUser());
        }

        $result = $this->getBaseManager()
                ->update($data, 'AppBundle:Locale', $id, $this->getLoggedUser());

        if ($result === 404) {
            throw new HttpException(404, "Locale with id " . $id . " not found!");
        } else if ($result === 401) {
            throw new AccessDeniedException();
        }

        $view = array(
            'status' => 200,
            'item' => $result,
            'message' => 'Locale updated!'
        );

        return $this->handleView($this->view($view));
    }

    /**
     * Delete specific locale
     * 
     * Path: /locales/{id}
     * Method: DELETE
     * 
     * @param {int} $id Locale identifier
     * @return {json} Status
     * 
     * @throws NotFoundHttpException when requested locale doesn't exist
     * @throws AccessDeniedException when user missmatch one defined in calendar
     */
    public function deleteLocaleAction($id) {
        $result = $this->getBaseManager()
                ->delete('AppBundle:Locale', $id, $this->getLoggedUser());

        if ($result === 404) {
            throw new HttpException(404, "Locale with id " . $id . " not found!");
        } else if ($result === 401) {
            throw new AccessDeniedException();
        }

        $view = array(
            'status' => 200,
            'message' => 'Locale successfully deleted!'
        );

        return $this->handleView($this->view($view));
    }

    /**
     * Initialize BaseManager
     * 
     * @return AppBundle\Services\BaseManager
     */
    protected function getBaseManager() {
        return $this->get('app.base_manager');
    }

    /**
     * Get currently logged user
     * 
     * @return {obj} User
     */
    protected function getLoggedUser() {
        return $this->get('security.token_storage')->getToken()->getUser();
    }

}
