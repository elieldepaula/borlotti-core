<?php

/**
 * Copyright (c) 2025 - Borlotti Project.
 *
 * Licensed under The MIT License
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright   Copyright (c) Eliel de Paula <elieldepaula@gmail.com>
 * @license     https://www.opensource.org/licenses/mit-license.php MIT License
 */

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
     * @param string $view
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
        $twig = Twig::fromRequest($request);
        return $twig->render($response, $view, $data);
    }
}