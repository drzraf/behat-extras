<?php
namespace BehatExtras\Extension;

use Behat\Behat\Extension\ExtensionInterface,
    Symfony\Component\Config\Definition\Builder\ArrayNodeDefinition,
    Symfony\Component\DependencyInjection\ContainerBuilder,
    Symfony\Component\DependencyInjection\Reference;

class MongoExtension implements ExtensionInterface
{
    protected $mongoClient;
    protected $mongoDatabase;

    /**
     * Loads a specific configuration.
     *
     * @param array            $config    Extension configuration hash (from behat.yml)
     * @param ContainerBuilder $container ContainerBuilder instance
     */
    public function load(array $config, ContainerBuilder $container)
    {
        $container->setParameter('mongo.host', $config['host']);
        $container->setParameter('mongo.database', $config['database']);

        $container->register('behat_extras.mongo.context.initializer', 'BehatExtras\Initializer\MongoInitializer')
            ->addArgument("%mongo.host%")
            ->addArgument("%mongo.database%")
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
            ->scalarNode('host')
                ->defaultValue('localhost')
            ->end()
            ->scalarNode('database')
                ->defaultValue('test')
            ->end()
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