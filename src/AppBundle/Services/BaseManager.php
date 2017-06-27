<?php

namespace AppBundle\Services;

use AppBundle\Entity\Log;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;

class BaseManager {

    protected $em;

    public function __construct($em) {
        $this->em = $em;
    }

    /**
     * Get all data from database
     * 
     * @param $repo Name of repo where to look
     * @param $user Currently logged user
     * @retun {Object} Data
     * 
     */
    public function getAll($repo, $user) {
        $obj = $this->em
                ->getRepository($repo)
                ->findByUser($user);

        if (empty($obj)) {
            throw new HttpException(204, "There is no items for requested data");
        }

        return $obj;
    }

    /**
     * Get all data from database without authorization
     * 
     * @param $repo Name of repo where to look
     * @retun {Object} Data
     * 
     */
    public function getAllWithoutAuth($repo) {
        $obj = $this->em
                ->getRepository($repo)
                ->findBy(array('active' => 1));

        if (empty($obj)) {
            throw new HttpException(204, "There is no items for requested data");
        }

        return $obj;
    }

    /**
     * Get specific data from database by parameters
     * 
     * @param $repo Name of repo where to look
     * @param $param {Array} Parameters to match
     * @param $user Currently logged user
     * @retun {Object} Data
     * 
     */
    public function getBy($repo, $param, $user) {
        $param['user'] = $user->getId();

        $obj = $this->em
                ->getRepository($repo)
                ->findBy($param);

        if (empty($obj)) {
            throw new HttpException(204, "There is no items for requested data");
        }

        return $obj;
    }

    /**
     * Get specific data from database by parameters without authentification
     * 
     * @param $repo Name of repo where to look
     * @param $param {Array} Parameters to match
     * @retun {Object} Data
     * 
     */
    public function getByWithoutAuth($repo, $param) {
        $param['active'] = '1';
        $obj = $this->em
                ->getRepository($repo)
                ->findBy($param);

        if (empty($obj)) {
            throw new HttpException(204, "There is no items for requested data");
        }

        return $obj;
    }

    /**
     * Get first data from database by parameters
     * 
     * @param $repo Name of repo where to look
     * @param $param {Array} Parameters to match
     * @param $user Currently logged user
     * @retun {Object} Data
     * 
     */
    public function getOneBy($repo, $param, $user) {
        $param['user'] = $user->getId();

        $obj = $this->em
                ->getRepository($repo)
                ->findOneBy($param);

        if (empty($obj)) {
            throw new HttpException(204, "There is no items for requested data");
        }

        return $obj;
    }

    /**
     * Get first data from database by parameters without authentification
     * 
     * @param $repo Name of repo where to look
     * @param $param {Array} Parameters to match
     * @retun {Object} Data
     * 
     */
    public function getOneByWithoutAuth($repo, $param) {
        $obj = $this->em
                ->getRepository($repo)
                ->findOneBy($param);

        if (empty($obj)) {
            throw new HttpException(204, "There is no items for requested data");
        }

        return $obj;
    }

    /**
     * Get specific data from database
     * 
     * @param $repo Name of repo where to look
     * @param $id Identifier
     * @param $user Currently logged user
     * @retun {Object} Data
     * 
     */
    public function get($repo, $id, $user) {
        $obj = $this->em
                ->getRepository($repo)
                ->find($id);

        if (empty($obj)) {
            throw new HttpException(204, "There is no items for requested data");
        }

        if ($user->getId() !== $obj->getUser()->getId()) {
            throw new AccessDeniedException();
        }

        return $obj;
    }

    /**
     * Get specific data from database without authentification
     * 
     * @param $repo Name of repo where to look
     * @param $id Identifier
     * @retun {Object} Data
     * 
     */
    public function getWithoutAuth($repo, $id) {
        $obj = $this->em
                ->getRepository($repo)
                ->find($id);

        if (empty($obj)) {
            throw new HttpException(204, "There is no items for requested data");
        }

        return $obj;
    }

    /**
     * Set new data in database
     * 
     * @param $obj Class of object
     * @param $repo Name of repo where to look
     * @param $data Data to be defined
     * @param $user Currently logged user
     * @retun {Object} Newly created object
     * 
     */
    public function set($obj, $repo, $data, $user) {
        $obj->setUser($user);
        $obj->setActive(1);

        foreach ($data as $key => $value) {
            $obj->setValue($key, $value);
        }

        $this->em->persist($obj);
        $this->em->flush();

        $this->logAction('Item ' . $obj->getId() . ' created in ' . $repo, $user);

        return array(
            'status' => 201,
            'item' => $obj,
            'message' => 'New item created'
        );
    }

    /**
     * Updating data in database
     * 
     * @param $data Data to be updated
     * @param $repo Name of repo whete to look
     * @param $id Identifier    
     * @param $user Currently logged user
     * @retun {Object} Updated object
     * 
     */
    public function update($data, $repo, $id, $user) {
        $obj = $this->em->getRepository($repo)->find($id);

        if (empty($obj)) {
            throw new HttpException(204, "There is no items for requested data");
        }

        if ($user->getId() !== $obj->getUser()->getId()) {
            throw new AccessDeniedException();
        }

        foreach ($data as $key => $value) {
            $obj->setValue($key, $value);
        }

        $this->em->flush();

        $this->logAction('Item ' . $obj->getId() . ' updated in ' . $repo, $user);

        return array(
            'status' => 200,
            'item' => $obj,
            'message' => 'Item updated'
        );
    }

    /**
     * Deactivating data in database
     * 
     * @param $repo Name of repo where to look
     * @param $id Identifier
     * @param $user Currently logged user
     * 
     */
    public function delete($repo, $id, $user) {
        $obj = $this->em->getRepository($repo)->find($id);
        $obj->setActive(0);

        if (empty($obj)) {
            throw new HttpException(204, "There is no items for requested data");
        }

        if ($user->getId() !== $obj->getUser()->getId()) {
            throw new AccessDeniedException();
        }

        $this->em->flush();

        $this->logAction('Item ' . $obj->getId() . ' deleted in ' . $repo, $user);

        return array(
            'status' => 200,
            'item' => $obj,
            'message' => 'Item deleted'
        );
    }

    /**
     * Deleting data from database
     * 
     * @param $repo Name of repo where to look
     * @param $id Identifier
     * @param $user Currently logged user
     * 
     */
    public function hardDelete($repo, $id, $user) {
        $obj = $this->em->getRepository($repo)->find($id);

        if (empty($obj)) {
            throw new HttpException(204, "There is no items for requested data");
        }

        if ($user->getId() !== $obj->getUser()->getId()) {
            throw new AccessDeniedException();
        }

        $this->em->remove($obj);
        $this->em->flush();

        $this->logAction('Item ' . $obj->getId() . ' hard deleted in ' . $repo, $user);

        return array(
            'status' => 200,
            'item' => $obj,
            'message' => 'Item hard deleted'
        );
    }

    /**
     * 
     * @param $message Log message
     * @param $user Currently logged user
     */
    public function logAction($message, $user) {
        $request = Request::createFromGlobals();

        $log = new Log();
        $log->setUser($user);
        $log->setIp($request->getClientIp());
        $log->setDescription($message);
        $log->setDate(new \DateTime());

        $this->em->persist($log);
        $this->em->flush();
    }

}
