<?php

declare(strict_types=1);

namespace Sacred\Packages\DoctrineMappingDriver\Mapping;

use Doctrine\ORM\Mapping\Builder\ClassMetadataBuilder;

interface DoctrineClassMappingConfigurator
{
    public function configure(ClassMetadataBuilder $builder): void;
    /** @return class-string */
    public static function getClassName(): string;
}
