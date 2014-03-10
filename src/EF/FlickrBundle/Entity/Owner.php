<?php
/**
 * Created by PhpStorm.
 * User: sasha
 * Date: 10.03.14
 * Time: 1:26
 */

namespace EF\FlickrBundle\Entity;


class Owner
{

    private $id;

    private $name;

    private $images;
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->images = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Set id
     *
     * @param string $id
     * @return Owner
     */
    public function setId($id)
    {
        $this->id = $id;

        return $this;
    }

    /**
     * Get id
     *
     * @return string 
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set name
     *
     * @param string $name
     * @return Owner
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
     * Add images
     *
     * @param \EF\FlickrBundle\Entity\Image $image
     * @return Owner
     */
    public function addImage(\EF\FlickrBundle\Entity\Image $image)
    {
        $this->images[] = $image;

        return $this;
    }

    /**
     * Remove images
     *
     * @param \EF\FlickrBundle\Entity\Image $image
     */
    public function removeImage(\EF\FlickrBundle\Entity\Image $image)
    {
        $this->images->removeElement($image);
    }

    /**
     * Get images
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getImages()
    {
        return $this->images;
    }
}
