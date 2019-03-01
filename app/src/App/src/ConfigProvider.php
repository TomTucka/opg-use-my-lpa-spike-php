<?php

declare(strict_types=1);

namespace App;

use CsrfMiddleware;
use JwtAuthenticationFactory;
use SessionMiddleware;
use SessionMiddlewareFactory;
use Tuupola\Middleware\JwtAuthentication;

/**
 * The configuration provider for the App module
 *
 * @see https://docs.zendframework.com/zend-component-installer/
 */
class ConfigProvider
{
    /**
     * Returns the configuration array
     *
     * To add a bit of a structure, each section is defined in a separate
     * method which returns an array with its configuration.
     *
     */
    public function __invoke() : array
    {
        return [
            'dependencies' => $this->getDependencies(),
            'templates'    => $this->getTemplates(),
        ];
    }

    /**
     * Returns the container dependencies
     */
    public function getDependencies() : array
    {
        return [
            'invokables' => [
                Handler\PingHandler::class => Handler\PingHandler::class,

            ],
            'factories'  => [

                // Handlers
                Handler\HomePageHandler::class => Handler\HomePageHandlerFactory::class,
                Handler\ConfirmViewHandler::class => Handler\ConfirmViewHandlerFactory::class,

                //Factories
                JwtAuthentication::class                            => Middleware\Session\JwtAuthenticationFactory::class,
                Middleware\Session\SessionMiddleware::class         => Middleware\Session\SessionMiddlewareFactory::class,
            ],
        ];
    }

    /**
     * Returns the templates configuration
     */
    public function getTemplates() : array
    {
        return [
            'paths' => [
                'app'    => [__DIR__ . '/../templates/app'],
                'error'  => [__DIR__ . '/../templates/error'],
                'layout' => [__DIR__ . '/../templates/layout'],
            ],
        ];
    }
}
