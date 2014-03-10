<?php
/**
 * Created by PhpStorm.
 * User: sasha
 * Date: 09.03.14
 * Time: 17:24
 */

namespace EF\FlickrBundle\Service;

use Zend\Http\Client\Adapter\Curl;
use Zend\Http\Client;
use ZendService\Flickr\Flickr as ZendFlickr;


class Flickr implements ImageSourceInterface
{
    /**
     * @var ZendFlickr
     */
    private $zendFlickr;

    public function __construct($apiKey)
    {
        /*$adapter = new Curl();
        $client = new Client();
        $client->setAdapter($adapter);*/
        $this->zendFlickr = new ZendFlickr($apiKey/*, $client*/);
    }

    public function getImages($searchTerm, $page = 1, $perPage = 100)
    {
        $images = array();
        $resultSet = $this->zendFlickr->tagSearch('', array('page' => $page, 'per_page' => $perPage, 'text' => $searchTerm));
        foreach ($resultSet as $result) {
            if (isset($result->Original))
            {
                $image = new Image();
                $image->id = $result->id;
                $image->owner = $result->owner;
                $image->ownerName = $result->ownername;
                $image->title = $result->title;
                $image->url = $result->Original->uri;
                $image->thumbnailUrl = $result->Small->uri;
                $image->width = $result->Original->width;
                $image->height = $result->Original->height;
                $images[] = $image;
            }
        }
        return $images;
    }
} 