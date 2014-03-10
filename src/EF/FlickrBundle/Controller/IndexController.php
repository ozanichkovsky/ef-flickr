<?php

namespace EF\FlickrBundle\Controller;

use EF\FlickrBundle\Entity\ImageRepository;
use EF\FlickrBundle\Form\Type\SearchType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

use Doctrine\ORM\EntityManager;

class IndexController extends Controller
{
    public function indexAction($page)
    {
        /* @var EntityManager $em */
        $em = $this->get('doctrine.orm.entity_manager');

        /* @var ImageRepository $repository */
        $repository = $em->getRepository('EFFlickrBundle:Image');

        $images = $repository->findByPageNumber($page);

        $count = $repository->getCount();

        $pages = ceil($count[0][1] / 20);

        $searchForm = $this->createForm(new SearchType());

        return $this->render('EFFlickrBundle:Index:index.html.twig', array(
            'images' => $images,
            'pages' => $pages,
            'current' => $page,
            'form' => $searchForm->createView()
        ));
    }

    public function searchAction(Request $request)
    {
        $form = $this->createForm(new SearchType());

        $form->handleRequest($request);

        if ($form->isValid())
        {
            $data = $form->getData();
            $page = $data['page'];
            unset($data['page']);
            /* @var EntityManager $em */
            $em = $this->get('doctrine.orm.entity_manager');

            /* @var ImageRepository $repository */
            $repository = $em->getRepository('EFFlickrBundle:Image');

            $images = $repository->findByPageNumber($page, $data);

            $count = $repository->getCount($data);

            $pages = ceil($count[0][1] / 20);
        }

        return $this->render('EFFlickrBundle:Index:content.html.twig', array(
            'images' => $images,
            'pages' => $pages,
            'current' => $page
        ));
    }
}