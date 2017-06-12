<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use JMS\Serializer\Annotation\ExclusionPolicy;
use JMS\Serializer\Annotation\Expose;

/**
 * @ORM\Entity
 * @ORM\Table(name="ninepixels_localization")
 * 
 * @ExclusionPolicy("all")
 */
class Localization {

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
     * @ORM\ManyToOne(targetEntity="Locale")
     * @ORM\JoinColumn(name="locale", referencedColumnName="id")
     */
    private $locale;

    /**
     * @ORM\Column(type="string", length=512, nullable=true)
     * @Expose
     */
    private $origin;

    /**
     * @ORM\Column(type="string", length=512, nullable=true)
     * @Expose
     */
    private $translate;

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
     * Set origin
     *
     * @param string $origin
     *
     * @return Localization
     */
    public function setOrigin($origin) {
        $this->origin = $origin;

        return $this;
    }

    /**
     * Get origin
     *
     * @return string
     */
    public function getOrigin() {
        return $this->origin;
    }

    /**
     * Set translate
     *
     * @param string $translate
     *
     * @return Localization
     */
    public function setTranslate($translate) {
        $this->translate = $translate;

        return $this;
    }

    /**
     * Get translate
     *
     * @return string
     */
    public function getTranslate() {
        return $this->translate;
    }

    /**
     * Set active
     *
     * @param integer $active
     *
     * @return Localization
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
     * Set user
     *
     * @param \AppBundle\Entity\User $user
     *
     * @return Localization
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
     * Set locale
     *
     * @param \AppBundle\Entity\Locale $locale
     *
     * @return Localization
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

}
