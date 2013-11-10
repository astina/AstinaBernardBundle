<?php

namespace Astina\Bundle\BernardBundle\DependencyInjection\Compiler;

use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Exception\RuntimeException;

class ReceiversPass implements CompilerPassInterface
{
    public function process(ContainerBuilder $container)
    {
        $tags = $container->findTaggedServiceIds('astina_bernard.receiver');

        $definition = $container->getDefinition('astina_bernard.receivers');

        foreach ($tags as $id => $attributes) {

            $attr = $attributes[0];

            if (!isset($attr['receiver'])) {
                throw new RuntimeException('"receiver" attribute not set for service tag');
            }

            if (!isset($attr['method'])) {
                throw new RuntimeException('"method" attribute not set for service tag');
            }

            $name = $attr['receiver'];
            $method = $attr['method'];

            $definition->addMethodCall('addReceiver', array($name, $id, $method));
        }
    }
}