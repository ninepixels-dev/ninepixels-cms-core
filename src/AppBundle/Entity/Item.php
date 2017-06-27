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
     * @ORM\ManyToOne(targetEntity="Language")
     * @ORM\JoinColumn(name="language", referencedColumnName="id", nullable=true)
     * @Expose
     */
    private $language;

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

}
