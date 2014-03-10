<?php

namespace EF\FlickrBundle\Command;

use Doctrine\ORM\EntityManager;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

use EF\FlickrBundle\Entity\Owner;
use EF\FlickrBundle\Entity\Image;

class ImageImportCommand extends ContainerAwareCommand
{
    protected function configure()
    {
        $this->setName('ef:import')->
            addArgument('text', InputArgument::OPTIONAL, 'Text to search for', 'education')->
            addArgument('pages', InputArgument::OPTIONAL, 'Number of pages to import', 2)->
            addArgument('per_page', InputArgument::OPTIONAL, 'Number of results per page', 10)->
            addArgument('start_page', InputArgument::OPTIONAL, 'Page to start import from', 1)->
            setDescription('Import images');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $importer = $this->getContainer()->get('ef_flickr.importer');
        $text = $input->getArgument('text');

        //TODO: check if these arguments are valid
        $pages = $input->getArgument('pages');
        $perPage = $input->getArgument('per_page');
        $startPage = $input->getArgument('start_page');

        $images = array();
        for ($i = $startPage; $i < $startPage + $pages; $i++)
        {
            $images = array_merge($images, $importer->getImages($text, $i, $perPage));
        }

        /* @var EntityManager $em */
        $em = $this->getContainer()->get('doctrine.orm.entity_manager');

        /* @var \EF\FlickrBundle\Service\Image $imageInfo */
        foreach ($images as $imageInfo)
        {
            //TODO: improve checking if owner exists to avoid separate query for each id
            /* @var Owner $owner */
            $owner = $em->getRepository('EFFlickrBundle:Owner')->findOneBy(array('id' => $imageInfo->owner));
            if (is_null($owner))
            {
                $owner = new Owner();
                $owner->setId($imageInfo->owner)->
                    setName($imageInfo->ownerName);
                $em->persist($owner);
             }

            //TODO: improve checking if image exists to avoid separate query for each id
            /* @var Image $image */
            $image = $em->getRepository('EFFlickrBundle:Image')->findOneBy(array('id' => $imageInfo->id));
            if (is_null($image)) {
                $image = new Image();
                $image->setId($imageInfo->id)->
                    setOwner($owner)->
                    setTitle($imageInfo->title)->
                    setUrl($imageInfo->url)->
                    setThumbnailUrl($imageInfo->thumbnailUrl)->
                    setHeight($imageInfo->height)->
                    setWidth($imageInfo->width);
                $em->persist($image);
            }
            $em->flush();
        }
    }
}