<?php

declare(strict_types=1);

namespace App\Blog\Post\Infrastructure\Doctrine\Mapping;

use App\Blog\Post\Domain\Entity\Post;
use Doctrine\ORM\Mapping\Builder\ClassMetadataBuilder;
use Sacred\Packages\DoctrineMappingDriver\Mapping\DoctrineClassMappingConfigurator;

class DoctrinePostConfigurator implements DoctrineClassMappingConfigurator
{
    public function configure(ClassMetadataBuilder $builder): void
    {
        $builder->setTable('posts');

        $builder->createField('id', 'uuid')
            ->makePrimaryKey()
            ->build();

        $builder->createField('title', 'string')
            ->build();

        $builder->createField('body', 'string')
            ->build();

        $builder->createField('authorId', 'uuid')
            ->build();

        $builder->createField('createdAt', 'datetime_immutable')
            ->build();

        $builder->createField('updatedAt', 'datetime_immutable')
            ->build();
    }

    public static function getClassName(): string
    {
        return Post::class;
    }
}