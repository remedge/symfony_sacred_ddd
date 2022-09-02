<?php

declare(strict_types=1);

namespace Sacred\Packages\DoctrineMappingDriver\DependencyInjection;

use Sacred\Packages\DoctrineMappingDriver\Mapping\DoctrineClassMappingDriver;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Extension\Extension;

class SacredDoctrineMappingDriverExtension extends Extension
{
    /**
     * @param array<mixed> $configs
     */
    public function load(array $configs, ContainerBuilder $containerBuilder): void
    {
        $containerBuilder->setParameter('doctrine.orm.metadata.php.class', DoctrineClassMappingDriver::class);
    }
}
