<?php

declare(strict_types=1);

use Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;

return static function (ContainerConfigurator $containerConfigurator): void {
    $containerConfigurator->extension(
        'doctrine',
        [
            'dbal' => [
                'url' => '%env(resolve:DATABASE_URL)%'
            ],
            'orm' => [
                'auto_generate_proxy_classes' => true,
                'naming_strategy' => 'doctrine.orm.naming_strategy.underscore_number_aware',
                'auto_mapping' => true,
                'mappings' => [
                    'User' => [
                        'type' => 'php',
                        'is_bundle' => false,
                        'dir' => '%kernel.project_dir%/src/Blog/User/Infrastructure/Doctrine/Mapping',
                        'prefix' => 'App\Blog\User\Domain\Entity',
                    ],
                    'Post' => [
                        'type' => 'php',
                        'is_bundle' => false,
                        'dir' => '%kernel.project_dir%/src/Blog/Post/Infrastructure/Doctrine/Mapping',
                        'prefix' => 'App\Blog\Post\Domain\Entity',
                    ]
                ],
            ]
        ]);
    if ($containerConfigurator->env() === 'test') {
        $containerConfigurator->extension('doctrine', [
            'dbal' => ['dbname_suffix' => '_test%env(default::TEST_TOKEN)%']
        ]);
    }
    if ($containerConfigurator->env() === 'prod') {
        $containerConfigurator->extension('doctrine', [
            'orm' => [
                'auto_generate_proxy_classes' => false,
                'query_cache_driver' => [
                    'type' => 'pool',
                    'pool' => 'doctrine.system_cache_pool'
                ],
                'result_cache_driver' => [
                    'type' => 'pool',
                    'pool' => 'doctrine.result_cache_pool'
                ]
            ]
        ]);
        $containerConfigurator->extension('framework', [
            'cache' => [
                'pools' => [
                    'doctrine.result_cache_pool' => [
                        'adapter' => 'cache.app'
                    ],
                    'doctrine.system_cache_pool' => [
                        'adapter' => 'cache.system'
                    ]
                ]
            ]
        ]);
    }
};
