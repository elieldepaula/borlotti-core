<?php

declare(strict_types=1);

namespace Borlotti\Core\Controller;

use Psr\Http\Message\ResponseInterface;
use Slim\Psr7\Request;
use Slim\Psr7\Response;
use Slim\Views\Twig;
use Twig\Error\LoaderError;
use Twig\Error\RuntimeError;
use Twig\Error\SyntaxError;

class HttpController
{

    /** @var string $moduleName */
    public string $moduleName = 'Web';

    /** @var string $viewFolder */
    public string $viewFolder = 'Views';

    /**
     * Render the view.
     *
     * @param String $view
     * @param array $data
     * @param Request $request
     * @param Response $response
     * @return ResponseInterface
     * @throws LoaderError
     * @throws RuntimeError
     * @throws SyntaxError
     */
    public function render(String $view, Array $data, Request $request, Response $response): ResponseInterface
    {
        $viewPath = 'Modules/' . $this->moduleName . '/' . $this->viewFolder . '/' . $view;
        $twig = Twig::fromRequest($request);
        return $twig->render($response, $viewPath, $data);
    }
}