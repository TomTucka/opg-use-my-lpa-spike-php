<?php

declare(strict_types=1);

namespace App\Handler;

use App\Handler\Traits\JwtTrait;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Zend\Diactoros\Response\HtmlResponse;
use Zend\Expressive\Router;
use Zend\Expressive\Template\TemplateRendererInterface;
use Zend\Expressive\Twig\TwigRenderer;
use Zend\Expressive\ZendView\ZendViewRenderer;

class HomePageHandler implements RequestHandlerInterface
{

    use JwtTrait;

    /** @var string */
    private $containerName;

    /** @var Router\RouterInterface */
    private $router;

    /** @var null|TemplateRendererInterface */
    private $template;

    public function __construct(
        string $containerName,
        Router\RouterInterface $router,
        ?TemplateRendererInterface $template = null
    ) {
        $this->containerName = $containerName;
        $this->router        = $router;
        $this->template      = $template;
    }

    public function handle(ServerRequestInterface $request) : ResponseInterface
    {
        if ($request->getMethod() == 'POST') {
            $data = $request->getParsedBody();
            $this->addTokenData('Data', $data);
            return new HtmlResponse($this->template->render('app::confirm-view', $data));
            //return new HtmlResponse(print_r($data, true));
        }


        return new HtmlResponse($this->template->render('app::home-page'));
    }
}
