<?php

namespace App\Middleware\Session;

use Interop\Container\ContainerInterface;

class SessionMiddlewareFactory
{
    /**
     * @param ContainerInterface $container
     * @return SessionMiddleware
     */
    public function __invoke(ContainerInterface $container)
    {
        $config = $container->get('config');

        return new SessionMiddleware($config['jwt']);
    }
}
