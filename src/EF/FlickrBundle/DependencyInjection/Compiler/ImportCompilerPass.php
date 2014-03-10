<?php
/**
 * Created by PhpStorm.
 * User: sasha
 * Date: 09.03.14
 * Time: 17:30
 */

namespace EF\FlickrBundle\DependencyInjection\Compiler;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\Reference;

class ImportCompilerPass implements CompilerPassInterface
{
    public function process(ContainerBuilder $container)
    {
        if (!$container->hasDefinition('ef_flickr.importer')) {
            return;
        }

        $definition = $container->getDefinition(
            'ef_flickr.importer'
        );

        $taggedServices = $container->findTaggedServiceIds(
            'ef_flickr.import'
        );
        foreach ($taggedServices as $id => $tagAttributes) {
            foreach ($tagAttributes as $attributes) {
                $definition->addMethodCall(
                    'addImageSource',
                    array(new Reference($id), $attributes["alias"])
                );
            }
        }
    }
} 