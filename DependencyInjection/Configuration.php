<?php

namespace CodeLovers\DoctrineEncryptBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

/**
 * This is the class that validates and merges configuration from your app/config files
 *
 * To learn more see {@link http://symfony.com/doc/current/cookbook/bundles/extension.html#cookbook-bundles-extension-config-class}
 */
class Configuration implements ConfigurationInterface
{
    /**
     * {@inheritDoc}
     */
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder();
        $rootNode = $treeBuilder->root('code_lovers_doctrine_encrypt');

        $rootNode
            ->children()

                ->scalarNode('driver')
                    ->defaultValue('orm')
                    ->isRequired()
                    ->validate()
                    ->ifNotInArray(array('odm', 'orm'))
                        ->thenInvalid('Invalid driver "%s"')
                    ->end()
                ->end()

                ->scalarNode('secret')->cannotBeEmpty()->isRequired()->end()

            ->end();

        return $treeBuilder;
    }
}
