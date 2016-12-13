<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\File;
use Vich\UploaderBundle\Mapping\Annotation as Vich;

/**
 * @ORM\Entity
 * @Vich\Uploadable
 * @ORM\Table(name="ninepixels_gallery")
 */
class Gallery {

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
     * @ORM\ManyToOne(targetEntity="Page")
     * @ORM\JoinColumn(name="page_id", referencedColumnName="id")
     */
    private $page;

    /**
     * @ORM\Column(type="string", length=64, nullable=true)
     */
    private $identifier;

    /**
     * @Vich\UploadableField(mapping="file", fileNameProperty="url")
     */
    private $file;

    /**
     * @ORM\Column(type="string", length=128, nullable=true)
     */
    private $url;

    /**
     * @ORM\Column(type="string", length=64, nullable=true)
     */
    private $video;

    /**
     * @ORM\Column(type="integer", options={"default" : 1})
     */
    private $preview;

    /**
     * @ORM\Column(type="integer", options={"default" : 1})
     */
    private $editable;

    /**
     * @ORM\Column(type="integer", options={"default" : 1})
     */
    private $delete;

    /**
     * Set file
     *
     * @param string $file
     *
     * @return Documents
     */
    public function setFile(File $file = null) {
        $this->file = $file;

        return $this;
    }

    /**
     * @return File|null
     */
    public function getFile() {
        return $this->file;
    }

    /**
     * Set documentUrl
     *
     * @param string $url
     *
     * @return Documents
     */
    public function setUrl($url) {
        $this->url = $url;

        return $this;
    }

    /**
     * Get documentUrl
     *
     * @return string
     */
    public function getUrl() {
        return $this->url;
    }

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
     * Set identifier
     *
     * @param string $identifier
     *
     * @return Gallery
     */
    public function setIdentifier($identifier)
    {
        $this->identifier = $identifier;

        return $this;
    }

    /**
     * Get identifier
     *
     * @return string
     */
    public function getIdentifier()
    {
        return $this->identifier;
    }

    /**
     * Set video
     *
     * @param string $video
     *
     * @return Gallery
     */
    public function setVideo($video)
    {
        $this->video = $video;

        return $this;
    }

    /**
     * Get video
     *
     * @return string
     */
    public function getVideo()
    {
        return $this->video;
    }

    /**
     * Set preview
     *
     * @param integer $preview
     *
     * @return Gallery
     */
    public function setPreview($preview)
    {
        $this->preview = $preview;

        return $this;
    }

    /**
     * Get preview
     *
     * @return integer
     */
    public function getPreview()
    {
        return $this->preview;
    }

    /**
     * Set editable
     *
     * @param integer $editable
     *
     * @return Gallery
     */
    public function setEditable($editable)
    {
        $this->editable = $editable;

        return $this;
    }

    /**
     * Get editable
     *
     * @return integer
     */
    public function getEditable()
    {
        return $this->editable;
    }

    /**
     * Set delete
     *
     * @param integer $delete
     *
     * @return Gallery
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
     * @return Gallery
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
     * @return Gallery
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
}
