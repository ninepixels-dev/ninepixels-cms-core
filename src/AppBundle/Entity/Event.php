<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use JMS\Serializer\Annotation\ExclusionPolicy;
use JMS\Serializer\Annotation\Expose;

/**
 * @ORM\Entity
 * @ORM\Table(name="ninepixels_events")
 * 
 * @ExclusionPolicy("all")
 */
class Event {

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
     * @ORM\ManyToOne(targetEntity="Language")
     * @ORM\JoinColumn(name="language", referencedColumnName="id", nullable=true)
     * @Expose
     */
    private $language;

    /**
     * @ORM\Column(type="string", length=256)
     * @Expose
     */
    private $title;

    /**
     * @ORM\Column(type="string", length=512)
     * @Expose
     */
    private $name;

    /**
     * @ORM\Column(type="text", nullable=true)
     * @Expose
     */
    private $description;

    /**
     * @ORM\Column(type="string", length=128, nullable=true)
     * @Expose
     */
    private $location;

    /**
     * @ORM\Column(type="datetime")
     * @Expose
     */
    private $dateFrom;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     * @Expose
     */
    private $dateTo;

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
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set title
     *
     * @param string $title
     *
     * @return Event
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
     * Set name
     *
     * @param string $name
     *
     * @return Event
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
     * Set description
     *
     * @param string $description
     *
     * @return Event
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
     * Set location
     *
     * @param string $location
     *
     * @return Event
     */
    public function setLocation($location)
    {
        $this->location = $location;

        return $this;
    }

    /**
     * Get location
     *
     * @return string
     */
    public function getLocation()
    {
        return $this->location;
    }

    /**
     * Set dateFrom
     *
     * @param \DateTime $dateFrom
     *
     * @return Event
     */
    public function setDateFrom($dateFrom)
    {
        $this->dateFrom = $dateFrom;

        return $this;
    }

    /**
     * Get dateFrom
     *
     * @return \DateTime
     */
    public function getDateFrom()
    {
        return $this->dateFrom;
    }

    /**
     * Set dateTo
     *
     * @param \DateTime $dateTo
     *
     * @return Event
     */
    public function setDateTo($dateTo)
    {
        $this->dateTo = $dateTo;

        return $this;
    }

    /**
     * Get dateTo
     *
     * @return \DateTime
     */
    public function getDateTo()
    {
        return $this->dateTo;
    }

    /**
     * Set active
     *
     * @param boolean $active
     *
     * @return Event
     */
    public function setActive($active)
    {
        $this->active = $active;

        return $this;
    }

    /**
     * Get active
     *
     * @return boolean
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
     * @return Event
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
     * Set page
     *
     * @param \AppBundle\Entity\Page $page
     *
     * @return Event
     */
    public function setPage(\AppBundle\Entity\Page $page = null)
    {
        $this->page = $page;

        return $this;
    }

    /**
     * Get page
     *
     * @return \AppBundle\Entity\Page
     */
    public function getPage()
    {
        return $this->page;
    }

    /**
     * Set language
     *
     * @param \AppBundle\Entity\Language $language
     *
     * @return Event
     */
    public function setLanguage(\AppBundle\Entity\Language $language = null)
    {
        $this->language = $language;

        return $this;
    }

    /**
     * Get language
     *
     * @return \AppBundle\Entity\Language
     */
    public function getLanguage()
    {
        return $this->language;
    }
}
