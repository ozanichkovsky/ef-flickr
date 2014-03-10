<?php

namespace EF\FlickrBundle\Service;

interface ImageSourceInterface
{
    public function getImages($searchTerm, $page = 1, $perPage = 5);
}