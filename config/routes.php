<?php

declare(strict_types=1);

use Symfony\Component\Routing\Loader\Configurator\RoutingConfigurator;

return static function (RoutingConfigurator $routingConfigurator): void {
    $routingConfigurator->import('../src/Blog/User', 'attribute');
    $routingConfigurator->import('../src/Blog/Post', 'attribute');
};
