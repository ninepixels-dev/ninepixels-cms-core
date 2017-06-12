<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Localization;
use FOS\RestBundle\Controller\FOSRestController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;

class LocalizationController extends FOSRestController {

    /**
     * Get all localizations
     * 
     * Path: /localizations
     * Method; GET
     * 
     * @return {json} List of localizations
     * 
     * @throws NotFoundHttpException when there is no localizations in database
     */
    public function getLocalizationsAction() {
        $item = $this->getBaseManager()
                ->getAllWithoutAuth('AppBundle:Localization');

        if (!$item) {
            throw new HttpException(204, "There is no localization for particular user");
        }

        return $this->handleView($this->view($item));
    }

    /**
     * Get specific localization requested by ID
     * 
     * Path: /localizations/{id}
     * Method: GET
     * 
     * @param {int} $id Localization identifier
     * @return {json} Localization requested by ID
     * 
     * @throws NotFoundHttpException when requested localization doesn't exist
     */
    public function getLocalizationAction($id) {
        $item = $this->getBaseManager()
                ->getWithoutAuth('AppBundle:Localization', $id);

        if (!$item) {
            throw new HttpException(404, "Localization not exist!");
        }

        return $this->handleView($this->view($item));
    }

    /**
     * Add new localization in database
     * 
     * Path: /localizations
     * Method: POST
     * 
     * @param {obj} $request Request object
     * @return {json} Status
     * 
     */
    public function postLocalizationAction(Request $request) {
        $data = $request->request->all();
        $item = new Localization();

        if (isset($data['locale'])) {
            $data['locale'] = $this->getBaseManager()
                    ->get('AppBundle:Locale', $data['locale'], $this->getLoggedUser());
        }

        $result = $this->getBaseManager()
                ->set($item, $data, $this->getLoggedUser());

        $view = array(
            'status' => 201,
            'item' => $result,
            'message' => 'New localization added to database!'
        );

        return $this->handleView($this->view($view));
    }

    /**
     * Update specific localization
     * 
     * Path: /localizations/{id}
     * Method: PUT
     * 
     * @param {int} $id Item identifier
     * @param {obj} $request Request object
     * @return {json} Status
     * 
     * @throws NotFoundHttpException when requested localization doesn't exist
     * @throws AccessDeniedException when user missmatch one defined in case
     */
    public function putLocalizationAction($id, Request $request) {
        $data = $request->request->all();

        if (isset($data['locale'])) {
            $data['locale'] = $this->getBaseManager()
                    ->get('AppBundle:Locale', $data['locale'], $this->getLoggedUser());
        }

        $result = $this->getBaseManager()
                ->update($data, 'AppBundle:Localization', $id, $this->getLoggedUser());

        if ($result === 404) {
            throw new HttpException(404, "Localization with id " . $id . " not found!");
        } else if ($result === 401) {
            throw new AccessDeniedException();
        }

        $view = array(
            'status' => 200,
            'item' => $result,
            'message' => 'Localization updated!'
        );

        return $this->handleView($this->view($view));
    }

    /**
     * Delete specific localization
     * 
     * Path: /localizations/{id}
     * Method: DELETE
     * 
     * @param {int} $id Localization identifier
     * @return {json} Status
     * 
     * @throws NotFoundHttpException when requested localization doesn't exist
     * @throws AccessDeniedException when user missmatch one defined in calendar
     */
    public function deleteLocalizationAction($id) {
        $result = $this->getBaseManager()
                ->delete('AppBundle:Localization', $id, $this->getLoggedUser());

        if ($result === 404) {
            throw new HttpException(404, "Localization with id " . $id . " not found!");
        } else if ($result === 401) {
            throw new AccessDeniedException();
        }

        $view = array(
            'status' => 200,
            'message' => 'Localization successfully deleted!'
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
