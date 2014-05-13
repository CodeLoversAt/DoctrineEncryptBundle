<?php

namespace CodeLovers\DoctrineEncryptBundle\DependencyInjection;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;
use Symfony\Component\DependencyInjection\Loader;

/**
 * This is the class that loads and manages your bundle configuration
 *
 * To learn more see {@link http://symfony.com/doc/current/cookbook/bundles/extension.html}
 */
class CodeLoversDoctrineEncryptExtension extends Extension
{
    /**
     * {@inheritDoc}
     */
    public function load(array $configs, ContainerBuilder $container)
    {
        $configuration = new Configuration();
        $config = $this->processConfiguration($configuration, $configs);

        $loader = new Loader\YamlFileLoader($container, new FileLocator(__DIR__.'/../Resources/config'));
        $loader->load('services.yml');

        if ('orm' === $config['driver']) {
            $definition = $container->getDefinition('code_lovers_doctrine_encrypt.listener.orm');
            $definition->addTag('doctrine.event_subscriber');
        } elseif ('odm' === $config['driver']) {
            $definition = $container->getDefinition('code_lovers_doctrine_encrypt.listener.odm');
            $definition->addTag('doctrine_mongodb.odm.event_subscriber');
        } else {
            throw new \RuntimeException('unknown driver: ' . $config['driver']);
        }

        $definition->addArgument($config['secret']);
    }
}
