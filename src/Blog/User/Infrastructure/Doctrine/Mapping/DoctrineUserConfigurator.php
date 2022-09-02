<?php

declare(strict_types=1);

namespace App\Blog\User\Infrastructure\Doctrine\Mapping;

use App\Blog\User\Domain\Entity\User;
use Doctrine\ORM\Mapping\Builder\ClassMetadataBuilder;
use Sacred\Packages\DoctrineMappingDriver\Mapping\DoctrineClassMappingConfigurator;

class DoctrineUserConfigurator implements DoctrineClassMappingConfigurator
{
    public function configure(ClassMetadataBuilder $builder): void
    {
        $builder->setTable('users');

        $builder->createField('id', 'uuid')
            ->makePrimaryKey()
            ->build();

        $builder->createField('email', 'string')
            ->build();

        $builder->createField('roles', 'json')
            ->build();

        $builder->createField('password', 'string')
            ->build();
    }

    public static function getClassName(): string
    {
        return User::class;
    }
}