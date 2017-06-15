<?php

namespace MusicManager\ManageBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Album
 */
class Album
{
    /**
     * @var integer
     */
    private $id;

    /**
     * @var string
     */
    private $name;

    /**
     * @var integer
     */
    private $released;

    /**
     * @var string
     */
    private $description;

    /**
     * @var integer
     */
    private $rate;

    /**
     * @var string
     */
    private $sleevePicFilename;

    /**
     * @var \MusicManager\ManageBundle\Entity\Band
     */
    private $band;

    private $imgDirectory = 'images';

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
     * @return Album
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
     * Set released
     *
     * @param integer $released
     * @return Album
     */
    public function setReleased($released)
    {
        $this->released = $released;

        return $this;
    }

    /**
     * Get released
     *
     * @return integer 
     */
    public function getReleased()
    {
        return $this->released;
    }

    /**
     * Set description
     *
     * @param string $description
     * @return Album
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
     * Set rate
     *
     * @param integer $rate
     * @return Album
     */
    public function setRate($rate)
    {
        $this->rate = $rate;

        return $this;
    }

    /**
     * Get rate
     *
     * @return integer 
     */
    public function getRate()
    {
        return $this->rate;
    }

    /**
     * Set sleevePicFilename
     *
     * @param string $sleevePicFilename
     * @return Album
     */
    public function setSleevePicFilename($sleevePicFilename)
    {
        $this->sleevePicFilename = $sleevePicFilename;

        return $this;
    }

    /**
     * Get sleevePicFilename
     *
     * @return string 
     */
    public function getSleevePicFilename()
    {
        return $this->sleevePicFilename;
    }

    /**
     * Set band
     *
     * @param \MusicManager\ManageBundle\Entity\Band $band
     * @return Album
     */
    public function setBand(\MusicManager\ManageBundle\Entity\Band $band = null)
    {
        $this->band = $band;

        return $this;
    }

    /**
     * Get band
     *
     * @return \MusicManager\ManageBundle\Entity\Band 
     */
    public function getBand()
    {
        return $this->band;
    }
    
    public function getFullPathToSleevePic() 
    {
//        return $_SERVER['DOCUMENT_ROOT'] . '/music-manager' .  $this->imgDirectory . '/' . $this->getSleevePicFilename();
//        return 'http://localhost/Projects/music-manager-2/web/images/102acb6.jpg';
//        return $_SERVER["SERVER_NAME"] . __DIR__;
    }
    
    public function __toString() 
    {
        return $this->name;
    }
}
