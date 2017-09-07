<?php

/*
 * (c) Jeroen van den Enden <info@endroid.nl>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace Endroid\PredictionIO\Bundle\PredictionIOBundle\DependencyInjection;

use Symfony\Component\DependencyInjection\Definition;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;
use Symfony\Component\DependencyInjection\ContainerBuilder;

/**
 * Class EndroidPredictionIOExtension.
 */
class EndroidPredictionIOExtension extends Extension
{
    /**
     * @param array            $configs
     * @param ContainerBuilder $container
     */
    public function load(array $configs, ContainerBuilder $container)
    {
        $configuration = new Configuration();
        $config = $this->processConfiguration($configuration, $configs);

        $eventServer = $config['event_server'];
        foreach ($config['apps'] as $app => $appConfig) {
            $eventClient = new Definition('Endroid\PredictionIO\EventClient');
            $eventClient
                ->addArgument($appConfig['key'])
                ->addArgument($eventServer['url'])
                ->addArgument($eventServer['timeout'])
                ->addArgument($eventServer['connect_timeout']);
            $eventClient->setLazy(true);
            $container->setDefinition(sprintf('endroid.prediction_io.%s.event_client', $app), $eventClient);
            foreach ($appConfig['engines'] as $engine => $engineConfig) {
                $engineClient = new Definition('Endroid\PredictionIO\EngineClient');
                $engineClient
                    ->addArgument($engineConfig['url'])
                    ->addArgument($engineConfig['timeout'])
                    ->addArgument($engineConfig['connect_timeout']);
                $engineClient->setLazy(true);
                $container->setDefinition(sprintf('endroid.prediction_io.%s.%s.engine_client', $app, $engine),
                    $engineClient
                );
            }
        }
    }
}
