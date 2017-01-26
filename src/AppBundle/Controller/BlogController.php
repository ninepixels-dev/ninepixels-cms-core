<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Blog;
use FOS\RestBundle\Controller\FOSRestController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;

class BlogController extends FOSRestController {

    /**
     * Get all blogs
     * 
     * Path: /blogs
     * Method; GET
     * 
     * @return {json} List of blogs
     * 
     * @throws NotFoundHttpException when there is no blogs in database
     */
    public function getBlogsAction() {
        $item = $this->getBaseManager()
                ->getAllWithoutAuth('AppBundle:Blog');

        if (!$item) {
            throw new HttpException(204, "There is no blog for particular user");
        }

        return $this->handleView($this->view($item));
    }

    /**
     * Get specific blog requested by ID
     * 
     * Path: /blogs/{id}
     * Method: GET
     * 
     * @param {int} $id Blog identifier
     * @return {json} Blog requested by ID
     * 
     * @throws NotFoundHttpException when requested option doesn't exist
     */
    public function getBlogAction($id) {
        $item = $this->getBaseManager()
                ->getWithoutAuth('AppBundle:Blog', $id);

        if (!$item) {
            throw new HttpException(404, "Blog not exist!");
        }

        return $this->handleView($this->view($item));
    }

    /**
     * Add new blog in database
     * 
     * Path: /blogs‚
     * Method: POST
     * 
     * @param {obj} $request Request object
     * @return {json} Status
     * 
     */
    public function postBlogAction(Request $request) {
        $data = $request->request->all();
        $item = new Blog();

        if (isset($data['image'])) {
            $data['image'] = $this->getBaseManager()
                    ->get('AppBundle:Image', $data['image'], $this->getLoggedUser());
        }

        $item->setCreated(new \DateTime());

        $result = $this->getBaseManager()
                ->set($item, $data, $this->getLoggedUser());

        $view = array(
            'status' => 201,
            'item' => $result,
            'message' => 'New blog added to database!'
        );

        return $this->handleView($this->view($view));
    }

    /**
     * Update specific blog
     * 
     * Path: /blogs/{id}
     * Method: PUT
     * 
     * @param {int} $id Item identifier
     * @param {obj} $request Request object
     * @return {json} Status
     * 
     * @throws NotFoundHttpException when requested option doesn't exist
     * @throws AccessDeniedException when user missmatch one defined in case
     */
    public function putBlogAction($id, Request $request) {
        $data = $request->request->all();

        if (isset($data['image'])) {
            $data['image'] = $this->getBaseManager()
                    ->get('AppBundle:Image', $data['image'], $this->getLoggedUser());
        } else {
            $data['image'] = NULL;
        }

        $data['edited'] = new \DateTime();

        $result = $this->getBaseManager()
                ->update($data, 'AppBundle:Blog', $id, $this->getLoggedUser());

        if ($result === 404) {
            throw new HttpException(404, "Blog with id " . $id . " not found!");
        } else if ($result === 401) {
            throw new AccessDeniedException();
        }

        $view = array(
            'status' => 200,
            'item' => $result,
            'message' => 'Blog updated!'
        );

        return $this->handleView($this->view($view));
    }

    /**
     * Delete specific blog
     * 
     * Path: /blogs/{id}
     * Method: DELETE
     * 
     * @param {int} $id Blog identifier
     * @return {json} Status
     * 
     * @throws NotFoundHttpException when requested option doesn't exist
     * @throws AccessDeniedException when user missmatch one defined in calendar
     */
    public function deleteBlogAction($id) {
        $result = $this->getBaseManager()
                ->delete('AppBundle:Blog', $id, $this->getLoggedUser());

        if ($result === 404) {
            throw new HttpException(404, "Blog with id " . $id . " not found!");
        } else if ($result === 401) {
            throw new AccessDeniedException();
        }

        $view = array(
            'status' => 200,
            'message' => 'Blog successfully deleted!'
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
