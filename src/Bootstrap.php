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

namespace Borlotti\Core;

use Borlotti\Core\Database\Connection;
use Slim\App;
use Slim\Factory\AppFactory;
use Slim\Views\Twig;
use Slim\Views\TwigMiddleware;
use DI\Container;
use Twig\Error\LoaderError;
use Twig\Loader\FilesystemLoader;
use Slim\Exception\HttpNotFoundException;
use Psr\Http\Message\ServerRequestInterface as Request;
use Throwable;
use function DI\autowire;


class Bootstrap
{

    /** @var App */
    private App $app;
    /** @var Container */
    private Container $container;
    /** @var Twig */
    private Twig $template;

    /**
     * Class constructor.
     */
    public function __construct()
    {
        $this->initDatabaseConnection();
        $this->container = new Container();
        AppFactory::setContainer($this->container);
        $this->app = AppFactory::create();
    }

    /**
     * Initiate the Database Connection.
     *
     * @return void
     */
    private function initDatabaseConnection(): void
    {
        Connection::init();
    }

    /**
     * Sets the application dependencies.
     *
     * Definition:
     *
     * [
     *     'Name\Space\ClassInterface::class' => 'Name\Space\Class::class'
     * ]
     *
     * @param $dependencies
     * @return $this
     */
    public function setDependencies($dependencies): Bootstrap
    {
        if (!is_array($dependencies) || empty($dependencies)) {
            return $this;
        }
        $this->_setDependencies($dependencies);
        return $this;
    }

    /**
     * Sets the application dependencies and merge the core dependencies.
     *
     * @param $dependencies
     * @return Bootstrap
     */
    private function _setDependencies($dependencies): Bootstrap
    {
        foreach ($dependencies as $interface => $class) {
            $this->container->set($interface, autowire($class));
        }
        return $this;
    }

    /**
     * Sets the application templates path.
     *
     * @param $path
     * @param $useCache
     * @return $this
     * @throws LoaderError
     */
    public function setTemplatesPath(FilesystemLoader $path, $useCache = false): Bootstrap
    {
        $this->template = new Twig($path, ['cache' => $useCache]);
        $twig = $this->template;

        // Custom Error Handler
        $customErrorHandler = function (
            Request $request,
            Throwable $exception,
            bool $displayErrorDetails,
            bool $logErrors,
            bool $logErrorDetails
        ) use ($twig) {
            $response = new \Slim\Psr7\Response();

            if ($exception instanceof HttpNotFoundException) {
                return $twig->render($response->withStatus(404), 'errors/404.twig', [
                    'message' => 'Page not found.'
                ]);
            }

            // Fallback for other errors.
            return $twig->render($response->withStatus(500), 'errors/500.twig', [
                'message' => $exception->getMessage()
            ]);
        };
        // Register the error middleware.
        $errorMiddleware = $this->app->addErrorMiddleware(true, true, true);
        $errorMiddleware->setDefaultErrorHandler($customErrorHandler);

        $this->app->add(TwigMiddleware::create($this->app, $this->template));
        $this->template->getEnvironment()->addFunction(new \Twig\TwigFunction('asset', function ($path) {
            return "/assets/" . ltrim($path, '/');
        }));
        return $this;
    }

    /**
     * Sets the application routes.
     *
     * Definition:
     * [
     *     'routeName' => [
     *         'path' => '/',
     *         'verb' => 'GET',
     *         'callable' => [App\Controllers\HomeController::class,'index']
     *     ],
     *     'test' => [
     *         'path' => '/test',
     *         'verb' => 'GET',
     *         'callable' => function (\Slim\Psr7\Request $request, \Slim\Psr7\Response $response) {
     *             $response->getBody()->write('Teste 1, 2, 3');
     *             return $response;
     *         }
     *     ]
     * ]
     *
     * @param $routes
     * @return $this
     */
    public function setRoutes($routes): Bootstrap
    {
        foreach ($routes as $name => $route) {

            $appRoute = $this->app->{strtolower($route['verb'])}(
                $route['path'],
                $route['callable']
            )->setName($name);

            if (isset($route['middleware'])) {
                $appRoute->add($routes['middleware']);
            }
        }
        return $this;
    }

    /**
     * Runs the application.
     *
     * @return void
     */
    public function run(): void
    {
        $coreDependency = require_once __DIR__ . '/Etc/Di.php';
        $this->_setDependencies($coreDependency);
        $this->app->run();
    }
}