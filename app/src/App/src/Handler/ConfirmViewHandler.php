<?php

declare(strict_types=1);

namespace App\Handler;

use App\Handler\Traits\JwtTrait;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Zend\Crypt\BlockCipher;
use Zend\Crypt\Symmetric\Openssl;
use Zend\Diactoros\Response\HtmlResponse;
use Zend\Expressive\Router;
use Zend\Expressive\Template\TemplateRendererInterface;
use Zend\Expressive\Twig\TwigRenderer;
use Zend\Expressive\ZendView\ZendViewRenderer;

class ConfirmViewHandler implements RequestHandlerInterface
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

    public function handle(ServerRequestInterface $request) : \Psr\Http\Message\ResponseInterface
    {
          $blockCipher = new BlockCipher(new Openssl(['algo' => 'aes']));
          $blockCipher->setKey('Baggies123');

          $data = $this->getTokenData('Data');
          $dataDecrypted = $blockCipher->decrypt($data);
          $dataDecoded = json_decode($dataDecrypted);

       return new HtmlResponse($this->template->render('app::confirm-view', $dataDecoded));
    }
}
