<?php
namespace BehatExtras\Extension;

use Behat\Behat\Extension\ExtensionInterface,
    Symfony\Component\Config\Definition\Builder\ArrayNodeDefinition,
    Symfony\Component\DependencyInjection\ContainerBuilder,
    Symfony\Component\DependencyInjection\Reference;

class InboxExtension implements ExtensionInterface
{
    /**
     * Loads a specific configuration.
     *
     * @param array            $config    Extension configuration hash (from behat.yml)
     * @param ContainerBuilder $container ContainerBuilder instance
     */
    public function load(array $config, ContainerBuilder $container)
    {
        $container->setParameter('inbox.config_options', $config);

        $container->register('behat_extras.inbox.context.initializer', 'BehatExtras\Initializer\InboxInitializer')
            ->addArgument("%inbox.config_options%")
            ->addTag('behat.context.initializer');

    }

    /**
     * Setups configuration for current extension.
     *
     * @param ArrayNodeDefinition $builder
     */
    public function getConfig(ArrayNodeDefinition $builder)
    {
        $builder->children()
            ->scalarNode('host')->end()
            ->scalarNode('protocol')->end()
            ->scalarNode('user')->end()
            ->scalarNode('port')->end()
            ->scalarNode('password')->end()
        ->end();
    }

    /**
     * Returns compiler passes used by this extension.
     *
     * @return array
     */
    public function getCompilerPasses()
    {
        return array();
    }
}