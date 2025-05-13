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

namespace Borlotti\Core\Library\Auth;

use Borlotti\Core\Api\Auth\AuthMiddlewareInterface;
use Borlotti\Core\Api\Auth\AuthServiceInterface;
use Borlotti\Core\Api\MessageManagerInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Slim\Psr7\Response;

class AuthMiddleware implements AuthMiddlewareInterface
{

    /** @var AuthServiceInterface $auth */
    protected AuthServiceInterface $auth;

    /** @var MessageManagerInterface $messageManager */
    private MessageManagerInterface $messageManager;

    /**
     * Class constructor.
     * @param AuthServiceInterface $auth
     * @param MessageManagerInterface $messageManager
     */
    public function __construct(
        AuthServiceInterface $auth,
        MessageManagerInterface $messageManager
    ) {
        $this->auth = $auth;
        $this->messageManager = $messageManager;
    }

    /**
     * @inheritDoc
     */
    public function __invoke(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {
        if (!$this->auth->user()) {
            $response = new Response();
            $this->messageManager->setFlashMessage('danger', 'Restricted area, login to proceed.');
            return $response
                ->withHeader('Location', '/login')
                ->withStatus(302);
        }

        return $handler->handle($request);
    }
}