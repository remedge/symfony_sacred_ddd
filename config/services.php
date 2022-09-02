<?php

declare(strict_types=1);

use App\Shared\Infrastructure\Symfony\Http\UuidValueResolver;
use Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;

return static function (ContainerConfigurator $containerConfigurator): void {
    $services = $containerConfigurator->services();

    $services->defaults()
        ->autowire()
        ->autoconfigure();

    $services->load('App\\', __DIR__ . '/../src/')
        ->exclude([
            __DIR__ . '/../src/DependencyInjection/',
            __DIR__ . '/../src/Entity/',
            __DIR__ . '/../src/Kernel.php'
        ]);

    $services->load('App\Blog\Post\Application\Controller\Api\\', __DIR__ . '/../src/Blog/Post/Application/Controller/Api/**/*Controller.php')
        ->tag('controller.service_arguments');

    $services->set(UuidValueResolver::class)
        ->tag('controller.argument_value_resolver', ['priority' => 500]);
};
