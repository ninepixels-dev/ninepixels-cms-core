<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use JMS\Serializer\Annotation\ExclusionPolicy;
use JMS\Serializer\Annotation\Expose;

/**
 * @ORM\Entity
 * @ORM\Table(name="ninepixels_locales")
 * 
 * @ExclusionPolicy("all")
 */
class Locale {

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
     * @ORM\ManyToOne(targetEntity="Language")
     * @ORM\JoinColumn(name="language", referencedColumnName="id")
     * @Expose
     */
    private $language;

    /**
     * @ORM\Column(type="string", length=512)
     * @Expose
     */
    private $origin;

    /**
     * @ORM\Column(type="string", length=512)
     * @Expose
     */
    private $translate;

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
     * Set origin
     *
     * @param string $origin
     *
     * @return Locale
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
     * @return Locale
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
     * @param boolean $active
     *
     * @return Locale
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
     * @return Locale
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
     * Set language
     *
     * @param \AppBundle\Entity\Language $language
     *
     * @return Locale
     */
    public function setLanguage(\AppBundle\Entity\Language $language = null) {
        $this->language = $language;

        return $this;
    }

    /**
     * Get language
     *
     * @return \AppBundle\Entity\Language
     */
    public function getLanguage() {
        return $this->language;
    }

}
