<?php

namespace Liip\FoxycartBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

class Configuration implements ConfigurationInterface
{
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder();
        $rootNode = $treeBuilder->root('liip_foxycart');

        $rootNode
            ->children()
                ->scalarNode('cart_url')->defaultNull()->end()
                ->scalarNode('api_key')->defaultNull()->end()
            ->end()
        ;

        return $treeBuilder;
    }
}
