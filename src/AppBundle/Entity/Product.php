<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use JMS\Serializer\Annotation\ExclusionPolicy;
use JMS\Serializer\Annotation\Expose;

/**
 * @ORM\Entity
 * @ORM\Table(name="ninepixels_product")
 * 
 * @ExclusionPolicy("all")
 */
class Product {

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
     * @ORM\Column(type="string", length=64)
     * @Expose
     */
    private $template;

    /**
     * @ORM\Column(type="string", length=256)
     * @Expose
     */
    private $name;

    /**
     * @ORM\Column(type="string", length=256, nullable=true)
     * @Expose
     */
    private $title;

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
     * @ORM\Column(type="integer", nullable=true)
     * @Expose
     */
    private $price;

    /**
     * @ORM\Column(type="string", length=64, nullable=true)
     * @Expose
     */
    private $currency;

    /**
     * @ORM\Column(type="integer", nullable=true)
     * @Expose
     */
    private $quantity;

    /**
     * @ORM\Column(type="integer", nullable=true)
     * @Expose
     */
    private $code;

    /**
     * @ORM\Column(type="text", nullable=true)
     * @Expose
     */
    private $description;

    /**
     * @ORM\Column(type="boolean", options={"default" : false}, nullable=true)
     * @Expose
     */
    private $pinned;

    /**
     * @ORM\Column(type="boolean", options={"default" : true}, nullable=true)
     * @Expose
     */
    private $visible;

    /**
     * @ORM\Column(type="boolean", options={"default" : true})
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
     * Set template
     *
     * @param string $template
     *
     * @return Product
     */
    public function setTemplate($template) {
        $this->template = $template;

        return $this;
    }

    /**
     * Get template
     *
     * @return string
     */
    public function getTemplate() {
        return $this->template;
    }

    /**
     * Set name
     *
     * @param string $name
     *
     * @return Product
     */
    public function setName($name) {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string
     */
    public function getName() {
        return $this->name;
    }

    /**
     * Set title
     *
     * @param string $title
     *
     * @return Product
     */
    public function setTitle($title) {
        $this->title = $title;

        return $this;
    }

    /**
     * Get title
     *
     * @return string
     */
    public function getTitle() {
        return $this->title;
    }

    /**
     * Set price
     *
     * @param string $price
     *
     * @return Product
     */
    public function setPrice($price) {
        $this->price = $price;

        return $this;
    }

    /**
     * Get price
     *
     * @return string
     */
    public function getPrice() {
        return $this->price;
    }

    /**
     * Set currency
     *
     * @param string $currency
     *
     * @return Product
     */
    public function setCurrency($currency) {
        $this->currency = $currency;

        return $this;
    }

    /**
     * Get currency
     *
     * @return string
     */
    public function getCurrency() {
        return $this->currency;
    }

    /**
     * Set quantity
     *
     * @param integer $quantity
     *
     * @return Product
     */
    public function setQuantity($quantity) {
        $this->quantity = $quantity;

        return $this;
    }

    /**
     * Get quantity
     *
     * @return integer
     */
    public function getQuantity() {
        return $this->quantity;
    }

    /**
     * Set code
     *
     * @param integer $code
     *
     * @return Product
     */
    public function setCode($code) {
        $this->code = $code;

        return $this;
    }

    /**
     * Get code
     *
     * @return integer
     */
    public function getCode() {
        return $this->code;
    }

    /**
     * Set description
     *
     * @param string $description
     *
     * @return Product
     */
    public function setDescription($description) {
        $this->description = $description;

        return $this;
    }

    /**
     * Get description
     *
     * @return string
     */
    public function getDescription() {
        return $this->description;
    }

    /**
     * Set pinned
     *
     * @param boolean $pinned
     *
     * @return Product
     */
    public function setPinned($pinned) {
        $this->pinned = $pinned;

        return $this;
    }

    /**
     * Get pinned
     *
     * @return boolean
     */
    public function getPinned() {
        return $this->pinned;
    }

    /**
     * Set visible
     *
     * @param boolean $visible
     *
     * @return Product
     */
    public function setVisible($visible) {
        $this->visible = $visible;

        return $this;
    }

    /**
     * Get visible
     *
     * @return boolean
     */
    public function getVisible() {
        return $this->visible;
    }

    /**
     * Set active
     *
     * @param boolean $active
     *
     * @return Product
     */
    public function setActive($active) {
        $this->active = $active;

        return $this;
    }

    /**
     * Get active
     *
     * @return boolean
     */
    public function getActive() {
        return $this->active;
    }

    /**
     * Set user
     *
     * @param \AppBundle\Entity\User $user
     *
     * @return Product
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
     * @return Product
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
     * @return Product
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
     * Set gallery
     *
     * @param \AppBundle\Entity\Gallery $gallery
     *
     * @return Product
     */
    public function setGallery(\AppBundle\Entity\Gallery $gallery = null) {
        $this->gallery = $gallery;

        return $this;
    }

    /**
     * Get gallery
     *
     * @return \AppBundle\Entity\Gallery
     */
    public function getGallery() {
        return $this->gallery;
    }

}
