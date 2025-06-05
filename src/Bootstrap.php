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
use Borlotti\Core\Library\EventManager;
use DI\DependencyException;
use DI\NotFoundException;
use Exception;
use Psr\Log\LoggerInterface;
use Slim\App;
use Slim\Factory\AppFactory;
use Slim\Views\Twig;
use Slim\Views\TwigMiddleware;
use DI\Container;
use Twig\Loader\FilesystemLoader;
use Slim\Exception\HttpNotFoundException;
use Psr\Http\Message\ServerRequestInterface as Request;
use Throwable;
use function DI\autowire;

class Bootstrap
{

    /** @var Bootstrap|null */
    private static ?Bootstrap $instance = null;
    /** @var App */
    private App $app;
    /** @var Container */
    private Container $container;

    /**
     * Class constructor.
     */
    private function __construct()
    {
        $this->initDatabaseConnection();
        $this->container = new Container();
        AppFactory::setContainer($this->container);
        $this->app = AppFactory::create();
    }

    /**
     * Get the singleton instance of Bootstrap.
     *
     * @return Bootstrap
     */
    public static function getInstance(): Bootstrap
    {
        if (self::$instance === null) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    /**
     * Get the app instance.
     *
     * @return App
     */
    public function getApp(): App
    {
        return $this->app;
    }

    /**
     * Get the container instance.
     *
     * @return Container
     */
    public function getContainer(): Container
    {
        return $this->container;
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
     * @return void
     */
    private function _setDependencies($dependencies): void
    {
        foreach ($dependencies as $interface => $class) {
            $this->container->set($interface, is_string($class) ? autowire($class) : $class);
        }
    }

    /**
     * Sets the application templates path.
     *
     * @param FilesystemLoader $path
     * @param bool $useCache
     * @return $this
     */
    public function setTemplatesPath(FilesystemLoader $path, bool $useCache = false): Bootstrap
    {
        $template = new Twig($path, ['cache' => $useCache]);
        $twig = $template;

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

        $this->app->add(TwigMiddleware::create($this->app, $template));
        $template->getEnvironment()->addFunction(new \Twig\TwigFunction('asset', function ($path) {
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
                $appRoute->add($route['middleware']);
            }
        }
        return $this;
    }

    /**
     * Set the application events.
     *
     * Definition:
     * [
     *     [
     *         'event' => 'before_save',
     *         'class' \Name\Space\Observer::class,
     *         'priority' = 100
     *     ]
     * ]
     *
     * Priority is optional, the default value is 100, from 0, 50, 100, 500 and 1000.
     *
     * @param $events
     * @return $this
     * @throws DependencyException
     * @throws NotFoundException
     */
    public function setEvents($events): Bootstrap
    {

        if (!is_array($events) || empty($events)) {
            return $this;
        }

        $eventManager = $this->container->get(EventManager::class);
        try {
            foreach ($events as $observer) {
                $eventName = $observer['event'];
                $instance = $this->container->get($observer['class']);
                $eventPriority = (isset($observer['priority'])) ? $observer['priority'] : 100;
                $eventManager->on($eventName, [$instance, 'execute'], $eventPriority);
            }
        } catch (Exception $e) {
            $logger = $this->container->get(LoggerInterface::class);
            $logger->error($e->getMessage());
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