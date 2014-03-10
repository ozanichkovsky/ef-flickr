<?php

namespace EF\FlickrBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

class SearchType extends  AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('title', 'text', array('required' => false));
        $builder->add('owner',  'text', array('required' => false));
        $builder->add('width', 'text', array('required' => false));
        $builder->add('height', 'text', array('required' => false));
        $builder->add('url', 'text', array('required' => false));
        $builder->add('page', 'hidden');
    }

    function getName() {
        return 'SearchType';
    }
} 