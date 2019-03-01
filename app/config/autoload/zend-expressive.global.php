<?php

declare(strict_types=1);

use Zend\ConfigAggregator\ConfigAggregator;

return [
    // Toggle the configuration cache. Set this to boolean false, or remove the
    // directive, to disable configuration caching. Toggling development mode
    // will also disable it by default; clear the configuration cache using
    // `composer clear-config-cache`.
    ConfigAggregator::ENABLE_CACHE => true,

    // Enable debugging; typically used to provide debugging information within templates.
    'debug' => false,

    'jwt' => [
        'secret'    => 'Z0E$L43c68%H2YI',
        'path'      => '/',
        'header'    => 'use-my-lpa',
        'cookie'    => 'use-my-lpa',
        'ttl'       => 60 * 15, //  15 minutes
        'algo'      => 'HS256',
    ],

    'zend-expressive' => [
        // Provide templates for the error handling middleware to use when
        // generating responses.
        'error_handler' => [
            'template_404'   => 'error::404',
            'template_error' => 'error::error',
        ],
    ],
];
