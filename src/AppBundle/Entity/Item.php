<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use JMS\Serializer\Annotation\ExclusionPolicy;
use JMS\Serializer\Annotation\Expose;

/**
 * @ORM\Entity
 * @ORM\Table(name="ninepixels_items")
 * 
 * @ExclusionPolicy("all")
 */
class Item {

    /**
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     * @Expose
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="User")
     * @ORM\JoinColumn(name="user_id", referencedColumnName="id")
     */
    private $user;

    /**
     * @ORM\ManyToOne(targetEntity="Page")
     * @ORM\JoinColumn(name="page_id", referencedColumnName="id")
     * @Expose
     */
    private $page;

    /**
     * @ORM\Column(type="string", length=64, nullable=true)
     * @Expose
     */
    private $identifier;

    /**
     * @ORM\Column(type="string", length=10960, nullable=true)
     * @Expose
     */
    private $structure;

    /**
     * @ORM\Column(type="string", length=64, nullable=true)
     * @Expose
     */
    private $image;

    /**
     * @ORM\Column(type="string", length=64, nullable=true)
     * @Expose
     */
    private $video;

    /**
     * @ORM\Column(type="string", length=64, nullable=true)
     * @Expose
     */
    private $class;

    /**
     * @ORM\Column(type="integer", options={"default" : 1})
     * @Expose
     */
    private $order;

    /**
     * @ORM\Column(type="integer", options={"default" : 1})
     * @Expose
     */
    private $editable;

    /**
     * @ORM\Column(type="integer", options={"default" : 1})
     * @Expose
     */
    private $delete;

    /**
     * Set values dinamicaly
     *
     * @return integer
     */
    public function setValue($key, $value) {
        if ($key !== 'user' && $key !== 'id') {
            $this->{$key} = $value;
            return $this;
        }
    }

    /**
     * Get id
     *
     * @return integer
     */
    public function getId() {
        return $this->id;
    }

    /**
     * Set identifier
     *
     * @param string $identifier
     *
     * @return Item
     */
    public function setIdentifier($identifier) {
        $this->identifier = $identifier;

        return $this;
    }

    /**
     * Get identifier
     *
     * @return string
     */
    public function getIdentifier() {
        return $this->identifier;
    }

    /**
     * Set structure
     *
     * @param string $structure
     *
     * @return Item
     */
    public function setStructure($structure) {
        $this->structure = $structure;

        return $this;
    }

    /**
     * Get structure
     *
     * @return string
     */
    public function getStructure() {
        return $this->structure;
    }

    /**
     * Set image
     *
     * @param string $image
     *
     * @return Item
     */
    public function setImage($image) {
        $this->image = $image;

        return $this;
    }

    /**
     * Get image
     *
     * @return string
     */
    public function getImage() {
        return $this->image;
    }

    /**
     * Set video
     *
     * @param string $video
     *
     * @return Item
     */
    public function setVideo($video) {
        $this->video = $video;

        return $this;
    }

    /**
     * Get video
     *
     * @return string
     */
    public function getVideo() {
        return $this->video;
    }

    /**
     * Set class
     *
     * @param string $class
     *
     * @return Item
     */
    public function setClass($class) {
        $this->class = $class;

        return $this;
    }

    /**
     * Get class
     *
     * @return string
     */
    public function getClass() {
        return $this->class;
    }

    /**
     * Set order
     *
     * @param integer $order
     *
     * @return Item
     */
    public function setOrder($order) {
        $this->order = $order;

        return $this;
    }

    /**
     * Get order
     *
     * @return integer
     */
    public function getOrder() {
        return $this->order;
    }

    /**
     * Set editable
     *
     * @param integer $editable
     *
     * @return Item
     */
    public function setEditable($editable) {
        $this->editable = $editable;

        return $this;
    }

    /**
     * Get editable
     *
     * @return integer
     */
    public function getEditable() {
        return $this->editable;
    }

    /**
     * Set delete
     *
     * @param integer $delete
     *
     * @return Item
     */
    public function setDelete($delete) {
        $this->delete = $delete;

        return $this;
    }

    /**
     * Get delete
     *
     * @return integer
     */
    public function getDelete() {
        return $this->delete;
    }

    /**
     * Set user
     *
     * @param \AppBundle\Entity\User $user
     *
     * @return Item
     */
    public function setUser(\AppBundle\Entity\User $user = null) {
        $this->user = $user;

        return $this;
    }

    /**
     * Get user
     *
     * @return \AppBundle\Entity\User
     */
    public function getUser() {
        return $this->user;
    }

    /**
     * Set page
     *
     * @param \AppBundle\Entity\Page $page
     *
     * @return Item
     */
    public function setPage(\AppBundle\Entity\Page $page = null) {
        $this->page = $page;

        return $this;
    }

    /**
     * Get page
     *
     * @return \AppBundle\Entity\Page
     */
    public function getPage() {
        return $this->page;
    }

}
