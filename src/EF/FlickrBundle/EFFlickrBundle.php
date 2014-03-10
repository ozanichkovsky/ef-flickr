<?php

namespace EF\FlickrBundle;

use Symfony\Component\HttpKernel\Bundle\Bundle;
use Symfony\Component\DependencyInjection\ContainerBuilder;

use EF\FlickrBundle\DependencyInjection\Compiler\ImportCompilerPass;
use EF\FlickrBundle\DependencyInjection\EFFlickrExtension;

class EFFlickrBundle extends Bundle
{
    public function build(ContainerBuilder $container)
    {
        parent::build($container);
        $container->registerExtension(new EFFlickrExtension());
        $container->addCompilerPass(new ImportCompilerPass());
    }
}
