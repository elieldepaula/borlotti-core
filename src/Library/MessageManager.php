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

namespace Borlotti\Core\Library;

use Borlotti\Core\Api\MessageManagerInterface;
use Borlotti\Core\Api\SessionInterface;

class MessageManager implements MessageManagerInterface
{

    /** @var SessionInterface $session */
    protected SessionInterface $session;

    /**
     * Class constructor.
     *
     * @param SessionInterface $session
     */
    public function __construct(
        SessionInterface $session
    ) {
        $this->session = $session;
    }

    /**
     * @inheritDoc
     */
    public function setFlashMessage(string $type, string $message): bool
    {
        $this->session->flash('flash', [
            'type' => $type,
            'message' => $message
        ]);
        return true;
    }

    /**
     * @inheritDoc
     */
    public function getFlashMessage(): array
    {
        return $this->session->getFlash('flash');
    }
}