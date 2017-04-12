<?php

namespace AppBundle\Services;

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
     * 
     * @retun {Object} Data
     * 
     */
    public function getAll($repo, $user) {
        $obj = $this->em
                ->getRepository($repo)
                ->findByUser($user);

        return $obj;
    }

    /**
     * Get all data from database without authorization
     * 
     * @param $repo Name of repo where to look
     * @param $user Currently logged user
     * 
     * @retun {Object} Data
     * 
     */
    public function getAllWithoutAuth($repo) {
        $obj = $this->em
                ->getRepository($repo)
                ->findBy(array('active' => 1));

        return $obj;
    }

    /**
     * Get specific data from database by parameters
     * 
     * @param $repo Name of repo where to look
     * @param $param {Array} Parameters to match
     * 
     * @retun {Object} Data
     * 
     */
    public function getBy($repo, $param, $user) {
        $param['user'] = $user->getId();

        $obj = $this->em
                ->getRepository($repo)
                ->findBy($param);

        return $obj;
    }

    /**
     * Get specific data from database by parameters without authentification
     * 
     * @param $repo Name of repo where to look
     * @param $param {Array} Parameters to match
     * 
     * @retun {Object} Data
     * 
     */
    public function getByWithoutAuth($repo, $param) {
        $param['active'] = '1';
        $obj = $this->em
                ->getRepository($repo)
                ->findBy($param);

        return $obj;
    }

    /**
     * Get first data from database by parameters
     * 
     * @param $repo Name of repo where to look
     * @param $param {Array} Parameters to match
     * 
     * @retun {Object} Data
     * 
     */
    public function getOneBy($repo, $param, $user) {
        $param['user'] = $user->getId();

        $obj = $this->em
                ->getRepository($repo)
                ->findOneBy($param);

        return $obj;
    }

    /**
     * Get first data from database by parameters without authentification
     * 
     * @param $repo Name of repo where to look
     * @param $param {Array} Parameters to match
     * 
     * @retun {Object} Data
     * 
     */
    public function getOneByWithoutAuth($repo, $param) {
        $obj = $this->em
                ->getRepository($repo)
                ->findOneBy($param);

        return $obj;
    }

    /**
     * Get specific data from database
     * 
     * @param $repo Name of repo where to look
     * @param $id Identifier
     * 
     * @retun {Object} Data
     * 
     */
    public function get($repo, $id, $user) {
        $obj = $this->em
                ->getRepository($repo)
                ->find($id);

        if ($user->getId() !== $obj->getUser()->getId()) {
            return 401;
        }

        return $obj;
    }

    /**
     * Get specific data from database without authentification
     * 
     * @param $repo Name of repo where to look
     * @param $id Identifier
     * 
     * @retun {Object} Data
     * 
     */
    public function getWithoutAuth($repo, $id) {
        $obj = $this->em
                ->getRepository($repo)
                ->find($id);

        return $obj;
    }

    /**
     * Set new data in database
     * 
     * @param $obj Class of object
     * @param $data Data to be defined
     * @param $user Currently logged user
     * 
     * @retun {Object} Newly created object
     * 
     */
    public function set($obj, $data, $user) {
        $obj->setUser($user);
        $obj->setActive(1);

        foreach ($data as $key => $value) {
            $obj->setValue($key, $value);
        }

        $this->em->persist($obj);

        $this->em->flush();

        return $obj;
    }

    /**
     * Updating data in database
     * 
     * @param $data Data to be updated
     * @param $repo Name of repo whete to look
     * @param $id Identifier    
     * @param $user Currently logged user
     * 
     * @retun {Object} Updated object
     * 
     */
    public function update($data, $repo, $id, $user) {
        $obj = $this->em->getRepository($repo)->find($id);

        if (!$obj) {
            return 404;
        }

        if ($user->getId() !== $obj->getUser()->getId()) {
            return 401;
        }

        foreach ($data as $key => $value) {
            $obj->setValue($key, $value);
        }

        $this->em->flush();

        return $obj;
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

        if (!$obj) {
            return 404;
        }

        if ($user->getId() !== $obj->getUser()->getId()) {
            return 401;
        }

        $obj->setActive(0);

        $this->em->flush();
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

        if (!$obj) {
            return 404;
        }

        if ($user->getId() !== $obj->getUser()->getId()) {
            return 401;
        }

        $this->em->remove($obj);
        $this->em->flush();
    }

}
