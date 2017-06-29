<?php

namespace MusicManager\ManageBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Song
 */
class Song
{
    /**
     * @var integer
     */
    private $id;

    /**
     * @var string
     */
    private $title;

    /**
     * @var string
     */
    private $length;

    /**
     * @var \MusicManager\ManageBundle\Entity\Album
     */
    private $album;


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
     * @return Song
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
     * Set length
     *
     * @param string $length
     * @return Song
     */
    public function setLength($length)
    {
        $this->length = $length;

        return $this;
    }

    /**
     * Get length
     *
     * @return string 
     */
    public function getLength()
    {
        return $this->length;
    }

    /**
     * Set album
     *
     * @param \MusicManager\ManageBundle\Entity\Album $album
     * @return Song
     */
    public function setAlbum(\MusicManager\ManageBundle\Entity\Album $album = null)
    {
        $this->album = $album;

        return $this;
    }

    /**
     * Get album
     *
     * @return \MusicManager\ManageBundle\Entity\Album 
     */
    public function getAlbum()
    {
        return $this->album;
    }
}
