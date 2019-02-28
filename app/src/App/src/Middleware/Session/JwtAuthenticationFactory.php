<?php
namespace App\Middleware\Session;

use DateTime;
use Firebase\JWT\JWT;
use Interop\Container\ContainerInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Tuupola\Middleware\JwtAuthentication;

class JwtAuthenticationFactory
{

    public function __invoke(ContainerInterface $container)
    {
        $jwtConfig = $container->get('config')['jwt'];
        //  Add JWT callback handlers to the config
        $jwtHandlers = [
            'before' => function (ServerRequestInterface $request, $params) use ($jwtConfig) {
                //  Move the existing JWT data to the session so we can get it after processing
                $_SESSION['jwt-payload'] = $request->getAttribute('token');
            },
            'after' => function (ResponseInterface $response, $params) use ($jwtConfig) {
                //  Re-set the JWT cookie using the updated data and a new timestamp
                $ttl = new DateTime(sprintf('+%s seconds', $jwtConfig['ttl']));
                $jwtCookie = JWT::encode($_SESSION['jwt-payload'], $jwtConfig['secret'], $jwtConfig['algo']);
                setcookie($jwtConfig['cookie'], $jwtCookie, $ttl->getTimeStamp(), '', '', true);
            },
        ];
        return new JwtAuthentication(array_merge($jwtConfig, $jwtHandlers));
    }

}
