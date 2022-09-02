<?php

declare(strict_types=1);

namespace Sacred\Packages\DoctrineMappingDriver\DependencyInjection\Compiler;

use Symfony\Component\Cache\Adapter\NullAdapter;
use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Definition;
use Symfony\Component\DependencyInjection\Reference;

class MappingConfiguratorCompilerPass implements CompilerPassInterface
{
    public function process(ContainerBuilder $containerBuilder): void
    {
        if (!$containerBuilder->hasDefinition('doctrine.orm.default_php_metadata_driver')) {
            return;
        }

        /** @var bool $debug */
        $debug = $containerBuilder->getParameter('kernel.debug');
        $cache = $debug ? new Definition(NullAdapter::class) : new Reference('cache.app');

        $containerBuilder->getDefinition('doctrine.orm.default_php_metadata_driver')
            ->setArgument(1, $cache);
    }
}
