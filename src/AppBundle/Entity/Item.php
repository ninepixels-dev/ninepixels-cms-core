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
     * @ORM\JoinColumn(name="user", referencedColumnName="id")
     */
    private $user;

    /**
     * @ORM\ManyToOne(targetEntity="Page")
     * @ORM\JoinColumn(name="page", referencedColumnName="id")
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
     * @ORM\ManyToOne(targetEntity="Image")
     * @ORM\JoinColumn(name="image", referencedColumnName="id")
     * @Expose
     */
    private $image;

    /**
     * @ORM\ManyToOne(targetEntity="Gallery")
     * @ORM\JoinColumn(name="gallery", referencedColumnName="id")
     * @Expose
     */
    private $gallery;

    /**
     * @ORM\ManyToOne(targetEntity="Locale")
     * @ORM\JoinColumn(name="locale", referencedColumnName="id", nullable=true)
     * @Expose
     */
    private $locale;

    /**
     * @ORM\Column(type="string", length=64, nullable=true)
     * @Expose
     */
    private $classes;

    /**
     * @ORM\Column(type="string", length=64, nullable=true)
     * @Expose
     */
    private $link;

    /**
     * @ORM\Column(type="string", length=64, nullable=true)
     * @Expose
     */
    private $video;

    /**
     * @ORM\Column(type="integer", options={"default" : 1}, nullable=true)
     * @Expose
     */
    private $position;

    /**
     * @ORM\Column(type="integer", options={"default" : 1}, nullable=true)
     * @Expose
     */
    private $editable;

    /**
     * @ORM\Column(type="integer", options={"default" : 1}, nullable=true)
     * @Expose
     */
    private $visible;

    /**
     * @ORM\Column(type="integer", options={"default" : 1})
     * @Expose
     */
    private $active;

    /**
     * Set values dinamicaly
     *
     * @return integer
     */
    public function setValue($key, $value) {
        if ($key !== 'user' && $key !== 'id') {
            $str = str_replace(' ', '', ucwords(str_replace('_', ' ', $key)));
            $str[0] = strtolower($str[0]);
            $this->{$str} = $value;
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
     * Set classes
     *
     * @param string $classes
     *
     * @return Item
     */
    public function setClasses($classes) {
        $this->classes = $classes;

        return $this;
    }

    /**
     * Get classes
     *
     * @return string
     */
    public function getClasses() {
        return $this->classes;
    }

    /**
     * Set position
     *
     * @param integer $position
     *
     * @return Item
     */
    public function setPosition($position) {
        $this->position = $position;

        return $this;
    }

    /**
     * Get position
     *
     * @return integer
     */
    public function getPosition() {
        return $this->position;
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
     * Set active
     *
     * @param integer $active
     *
     * @return Item
     */
    public function setActive($active) {
        $this->active = $active;

        return $this;
    }

    /**
     * Get active
     *
     * @return integer
     */
    public function getActive() {
        return $this->active;
    }

    /**
     * Set visible
     *
     * @param integer $visible
     *
     * @return Item
     */
    public function setVisible($visible) {
        $this->visible = $visible;

        return $this;
    }

    /**
     * Get visible
     *
     * @return integer
     */
    public function getVisible() {
        return $this->visible;
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

    /**
     * Set image
     *
     * @param \AppBundle\Entity\Image $image
     *
     * @return Item
     */
    public function setImage(\AppBundle\Entity\Image $image = null) {
        $this->image = $image;

        return $this;
    }

    /**
     * Get image
     *
     * @return \AppBundle\Entity\Image
     */
    public function getImage() {
        return $this->image;
    }

    /**
     * Set locale
     *
     * @param \AppBundle\Entity\Locale $locale
     *
     * @return Item
     */
    public function setLocale(\AppBundle\Entity\Locale $locale = null) {
        $this->locale = $locale;

        return $this;
    }

    /**
     * Get locale
     *
     * @return \AppBundle\Entity\Locale
     */
    public function getLocale() {
        return $this->locale;
    }

    /**
     * Set link
     *
     * @param string $link
     *
     * @return Item
     */
    public function setLink($link) {
        $this->link = $link;

        return $this;
    }

    /**
     * Get link
     *
     * @return string
     */
    public function getLink() {
        return $this->link;
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
     * Set gallery
     *
     * @param \AppBundle\Entity\Gallery $gallery
     *
     * @return Item
     */
    public function setGallery(\AppBundle\Entity\Gallery $gallery = null)
    {
        $this->gallery = $gallery;

        return $this;
    }

    /**
     * Get gallery
     *
     * @return \AppBundle\Entity\Gallery
     */
    public function getGallery()
    {
        return $this->gallery;
    }
}
