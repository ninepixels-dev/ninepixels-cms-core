<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="ninepixels_pages")
 */
class Page {

    /**
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="User")
     * @ORM\JoinColumn(name="user_id", referencedColumnName="id")
     */
    private $user;

    /**
     * @ORM\Column(type="string", length=64, nullable=true)
     */
    private $name;

    /**
     * @ORM\Column(type="string", length=64, nullable=true)
     */
    private $template;

    /**
     * @ORM\Column(type="string", length=64, nullable=true)
     */
    private $navigationName;

    /**
     * @ORM\Column(type="string", length=64, nullable=true)
     */
    private $title;

    /**
     * @ORM\Column(type="string", length=256, nullable=true)
     */
    private $description;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $parent;

    /**
     * @ORM\Column(type="integer", nullable=true, options={"default" : 1})
     */
    private $header;

    /**
     * @ORM\Column(type="integer", nullable=true, options={"default" : 1})
     */
    private $navigation;

    /**
     * @ORM\Column(type="integer", nullable=true, options={"default" : 1})
     */
    private $footer;

    /**
     * @ORM\Column(type="integer", nullable=true, options={"default" : 1})
     */
    private $inNavigation;

    /**
     * @ORM\Column(type="integer", options={"default" : 1})
     */
    private $active;

    /**
     * @ORM\Column(type="integer", options={"default" : 1})
     */
    private $order;

    /**
     * @ORM\Column(type="integer", options={"default" : 1})
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
     * Set navigationName
     *
     * @param string $navigationName
     *
     * @return Page
     */
    public function setNavigationName($navigationName)
    {
        $this->navigationName = $navigationName;

        return $this;
    }

    /**
     * Get navigationName
     *
     * @return string
     */
    public function getNavigationName()
    {
        return $this->navigationName;
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
     * Set parent
     *
     * @param integer $parent
     *
     * @return Page
     */
    public function setParent($parent)
    {
        $this->parent = $parent;

        return $this;
    }

    /**
     * Get parent
     *
     * @return integer
     */
    public function getParent()
    {
        return $this->parent;
    }

    /**
     * Set header
     *
     * @param integer $header
     *
     * @return Page
     */
    public function setHeader($header)
    {
        $this->header = $header;

        return $this;
    }

    /**
     * Get header
     *
     * @return integer
     */
    public function getHeader()
    {
        return $this->header;
    }

    /**
     * Set navigation
     *
     * @param integer $navigation
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
     * @return integer
     */
    public function getNavigation()
    {
        return $this->navigation;
    }

    /**
     * Set footer
     *
     * @param integer $footer
     *
     * @return Page
     */
    public function setFooter($footer)
    {
        $this->footer = $footer;

        return $this;
    }

    /**
     * Get footer
     *
     * @return integer
     */
    public function getFooter()
    {
        return $this->footer;
    }

    /**
     * Set inNavigation
     *
     * @param integer $inNavigation
     *
     * @return Page
     */
    public function setInNavigation($inNavigation)
    {
        $this->inNavigation = $inNavigation;

        return $this;
    }

    /**
     * Get inNavigation
     *
     * @return integer
     */
    public function getInNavigation()
    {
        return $this->inNavigation;
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
     * Set order
     *
     * @param integer $order
     *
     * @return Page
     */
    public function setOrder($order)
    {
        $this->order = $order;

        return $this;
    }

    /**
     * Get order
     *
     * @return integer
     */
    public function getOrder()
    {
        return $this->order;
    }

    /**
     * Set delete
     *
     * @param integer $delete
     *
     * @return Page
     */
    public function setDelete($delete)
    {
        $this->delete = $delete;

        return $this;
    }

    /**
     * Get delete
     *
     * @return integer
     */
    public function getDelete()
    {
        return $this->delete;
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
}
