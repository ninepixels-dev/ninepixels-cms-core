<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use JMS\Serializer\Annotation\ExclusionPolicy;
use JMS\Serializer\Annotation\Expose;

/**
 * @ORM\Entity
 * @ORM\Table(name="ninepixels_pages")
 * 
 * @ExclusionPolicy("all")
 */
class Page {

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
     * @ORM\JoinColumn(name="parent", referencedColumnName="id")
     * @Expose
     */
    private $parent;

    /**
     * @ORM\Column(type="string", length=64, nullable=true)
     * @Expose
     */
    private $name;

    /**
     * @ORM\Column(type="string", length=64)
     * @Expose
     */
    private $template;

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
     * @ORM\Column(type="string", length=64, nullable=true)
     * @Expose
     */
    private $navigation;

    /**
     * @ORM\Column(type="string", length=64, nullable=true)
     * @Expose
     */
    private $title;

    /**
     * @ORM\Column(type="string", length=256, nullable=true)
     * @Expose
     */
    private $description;

    /**
     * @ORM\Column(type="integer", nullable=true, options={"default" : 1})
     * @Expose
     */
    private $showHeader;

    /**
     * @ORM\Column(type="integer", nullable=true, options={"default" : 1})
     * @Expose
     */
    private $showNavigation;

    /**
     * @ORM\Column(type="integer", nullable=true, options={"default" : 1})
     * @Expose
     */
    private $showFooter;

    /**
     * @ORM\Column(type="integer", nullable=true, options={"default" : 1})
     * @Expose
     */
    private $showInNavigation;

    /**
     * @ORM\Column(type="integer", nullable=true, options={"default" : 1})
     * @Expose
     */
    private $visible;

    /**
     * @ORM\Column(type="integer", nullable=true, options={"default" : 1})
     * @Expose
     */
    private $position;

    /**
     * @ORM\Column(type="integer", nullable=true, options={"default" : 1})
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
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set name
     *
     * @param string $name
     *
     * @return Page
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set template
     *
     * @param string $template
     *
     * @return Page
     */
    public function setTemplate($template)
    {
        $this->template = $template;

        return $this;
    }

    /**
     * Get template
     *
     * @return string
     */
    public function getTemplate()
    {
        return $this->template;
    }

    /**
     * Set navigation
     *
     * @param string $navigation
     *
     * @return Page
     */
    public function setNavigation($navigation)
    {
        $this->navigation = $navigation;

        return $this;
    }

    /**
     * Get navigation
     *
     * @return string
     */
    public function getNavigation()
    {
        return $this->navigation;
    }

    /**
     * Set title
     *
     * @param string $title
     *
     * @return Page
     */
    public function setTitle($title)
    {
        $this->title = $title;

        return $this;
    }

    /**
     * Get title
     *
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * Set description
     *
     * @param string $description
     *
     * @return Page
     */
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Get description
     *
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Set showHeader
     *
     * @param integer $showHeader
     *
     * @return Page
     */
    public function setShowHeader($showHeader)
    {
        $this->showHeader = $showHeader;

        return $this;
    }

    /**
     * Get showHeader
     *
     * @return integer
     */
    public function getShowHeader()
    {
        return $this->showHeader;
    }

    /**
     * Set showNavigation
     *
     * @param integer $showNavigation
     *
     * @return Page
     */
    public function setShowNavigation($showNavigation)
    {
        $this->showNavigation = $showNavigation;

        return $this;
    }

    /**
     * Get showNavigation
     *
     * @return integer
     */
    public function getShowNavigation()
    {
        return $this->showNavigation;
    }

    /**
     * Set showFooter
     *
     * @param integer $showFooter
     *
     * @return Page
     */
    public function setShowFooter($showFooter)
    {
        $this->showFooter = $showFooter;

        return $this;
    }

    /**
     * Get showFooter
     *
     * @return integer
     */
    public function getShowFooter()
    {
        return $this->showFooter;
    }

    /**
     * Set showInNavigation
     *
     * @param integer $showInNavigation
     *
     * @return Page
     */
    public function setShowInNavigation($showInNavigation)
    {
        $this->showInNavigation = $showInNavigation;

        return $this;
    }

    /**
     * Get showInNavigation
     *
     * @return integer
     */
    public function getShowInNavigation()
    {
        return $this->showInNavigation;
    }

    /**
     * Set visible
     *
     * @param integer $visible
     *
     * @return Page
     */
    public function setVisible($visible)
    {
        $this->visible = $visible;

        return $this;
    }

    /**
     * Get visible
     *
     * @return integer
     */
    public function getVisible()
    {
        return $this->visible;
    }

    /**
     * Set position
     *
     * @param integer $position
     *
     * @return Page
     */
    public function setPosition($position)
    {
        $this->position = $position;

        return $this;
    }

    /**
     * Get position
     *
     * @return integer
     */
    public function getPosition()
    {
        return $this->position;
    }

    /**
     * Set active
     *
     * @param integer $active
     *
     * @return Page
     */
    public function setActive($active)
    {
        $this->active = $active;

        return $this;
    }

    /**
     * Get active
     *
     * @return integer
     */
    public function getActive()
    {
        return $this->active;
    }

    /**
     * Set user
     *
     * @param \AppBundle\Entity\User $user
     *
     * @return Page
     */
    public function setUser(\AppBundle\Entity\User $user = null)
    {
        $this->user = $user;

        return $this;
    }

    /**
     * Get user
     *
     * @return \AppBundle\Entity\User
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * Set parent
     *
     * @param \AppBundle\Entity\Page $parent
     *
     * @return Page
     */
    public function setParent(\AppBundle\Entity\Page $parent = null)
    {
        $this->parent = $parent;

        return $this;
    }

    /**
     * Get parent
     *
     * @return \AppBundle\Entity\Page
     */
    public function getParent()
    {
        return $this->parent;
    }

    /**
     * Set image
     *
     * @param \AppBundle\Entity\Image $image
     *
     * @return Page
     */
    public function setImage(\AppBundle\Entity\Image $image = null)
    {
        $this->image = $image;

        return $this;
    }

    /**
     * Get image
     *
     * @return \AppBundle\Entity\Image
     */
    public function getImage()
    {
        return $this->image;
    }

    /**
     * Set gallery
     *
     * @param \AppBundle\Entity\Gallery $gallery
     *
     * @return Page
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
