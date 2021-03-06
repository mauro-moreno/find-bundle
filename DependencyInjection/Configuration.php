<?php
/**
 * Class Configuration
 * @author Mauro Moreno <moreno.mauro.emanuel@gmail.com>
 */
namespace MauroMoreno\FindBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

/**
 * Class Configuration
 * @package MauroMoreno\FindBundle\DependencyInjection
 */
class Configuration implements ConfigurationInterface
{

    /**
     * Get config tree builder
     * @return TreeBuilder
     */
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder();
        $rootNode = $treeBuilder->root('mauro_moreno_find');
        $rootNode
            ->isRequired()
            ->children()
                ->scalarNode('find_directory_service')
                    ->isRequired()
                ->end()
                ->scalarNode('finder')
                    ->isRequired()
                ->end()
                ->scalarNode('lister')
                    ->isRequired()
                ->end()
            ->end();

        return $treeBuilder;
    }

}
