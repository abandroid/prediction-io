<?php

/*
 * (c) Jeroen van den Enden <info@endroid.nl>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace Endroid\PredictionIO\Bundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

/**
 * Class Configuration.
 */
class Configuration implements ConfigurationInterface
{
    /**
     * {@inheritdoc}
     */
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder();

        $treeBuilder
            ->root('endroid_prediction_io')
                ->children()
                    ->arrayNode('event_server')
                        ->children()
                            ->scalarNode('url')
                                ->defaultValue('http://localhost:7070')
                                ->isRequired()
                            ->end()
                            ->scalarNode('timeout')
                                ->defaultValue(0)
                            ->end()
                            ->scalarNode('connect_timeout')
                                ->defaultValue(5)
                            ->end()
                        ->end()
                    ->end()
                    ->arrayNode('apps')
                        ->isRequired()
                        ->requiresAtLeastOneElement()
                        ->useAttributeAsKey('app')
                        ->prototype('array')
                            ->children()
                                ->scalarNode('key')
                                    ->isRequired()
                                    ->cannotBeEmpty()
                                ->end()
                                ->arrayNode('engines')
                                    ->isRequired()
                                    ->requiresAtLeastOneElement()
                                    ->useAttributeAsKey('engine')
                                        ->prototype('array')
                                            ->children()
                                                ->scalarNode('url')
                                                    ->defaultValue('http://localhost:8000')
                                                ->end()
                                                ->scalarNode('timeout')
                                                    ->defaultValue(0)
                                                ->end()
                                                ->scalarNode('connect_timeout')
                                                    ->defaultValue(5)
                                                ->end()
                                            ->end()
                                        ->end()
                                    ->end()
                                ->end()
                            ->end()
                        ->end()
                    ->end()
                ->end()
        ;

        return $treeBuilder;
    }
}
