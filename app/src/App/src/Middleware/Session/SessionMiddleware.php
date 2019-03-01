<?php

namespace App\Middleware\Session;

use Firebase\JWT\JWT;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;

class SessionMiddleware implements MiddlewareInterface
{

    /**
     * @var array
     */
    private $jwtConfig;
    /**
     * SignInHandler constructor.
     * @param array $jwtConfig
     */
    public function __construct(array $jwtConfig)
    {
        $this->jwtConfig = $jwtConfig;
    }

    public function process(ServerRequestInterface $request,
                            RequestHandlerInterface $handler): \Psr\Http\Message\ResponseInterface
    {
        //  If there is no existing JWT cookie then create a new blank JWT token
        if (!array_key_exists($this->jwtConfig['cookie'], $_COOKIE)) {
            $tokenPayloadIn = [];
            $token = JWT::encode($tokenPayloadIn, $this->jwtConfig['secret'], $this->jwtConfig['algo']);
            $request = $request->withHeader($this->jwtConfig['header'], 'Bearer ' . $token);
            $request = $request->withAttribute('token', $tokenPayloadIn);
        }
        return $handler->handle($request);
    }

}
