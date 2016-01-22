<?php
/**
 * Class Configuration
 * @author Mauro Moreno <moreno.mauro.emanuel@gmail.com>
 */
namespace MauroMoreno\GrepBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

/**
 * Class Configuration
 * @package MauroMoreno\GrepBundle\DependencyInjection
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
        $rootNode = $treeBuilder->root('mauro_moreno_grep');

        return $treeBuilder;
    }

}