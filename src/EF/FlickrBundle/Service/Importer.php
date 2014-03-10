<?php
/**
 * Created by PhpStorm.
 * User: sasha
 * Date: 09.03.14
 * Time: 17:18
 */

namespace EF\FlickrBundle\Service;

use EF\FlickrBundle\Service\ImageSourceInterface;


class Importer
{
    private $imageSources;

    public function __construct()
    {
        $this->imageSources = array();
    }

    public function addImageSource(ImageSourceInterface $imageSource, $alias)
    {
        $this->imageSources[$alias] = $imageSource;
    }

    public function getImageSource($alias)
    {
        if (array_key_exists($alias, $this->imageSources)) {
            return $this->imageSources[$alias];
        }
    }

    public function getImages()
    {
        $images = array();
        foreach ($this->imageSources as $imageSource)
        {
            $images = array_merge($images, $imageSource->getImages('education'));
        }
        return $images;
    }
} 