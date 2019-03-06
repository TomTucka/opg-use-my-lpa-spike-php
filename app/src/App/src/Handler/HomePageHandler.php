<?php

declare(strict_types=1);

namespace App\Handler;

use App\Handler\Traits\JwtTrait;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Zend\Crypt\BlockCipher;
use Zend\Crypt\Symmetric\Openssl;
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

    /**
     * @var BlockCipher
     */
    private $blockCipher;

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
            $blockCipher = new BlockCipher(new Openssl(['algo' => 'aes']));
            $blockCipher->setKey('Baggies123');

            $jsonData = json_encode($data);
            $result = $blockCipher->encrypt($jsonData);

            $this->addTokenData('Data', $result);


            $data = $this->getTokenData('Data');
            $data = $blockCipher->decrypt($data);

            $jsonData = json_decode($data);


            return new HtmlResponse($this->template->render('app::confirm-view', $jsonData));
            //('app::confirm-view', $data));
            //return new HtmlResponse(print_r($data, true));
        }

        return new HtmlResponse($this->template->render('app::home-page'));
    }
}
