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

namespace Borlotti\Core\Library\Session;

use Borlotti\Core\Library\Session\Database\SessionModel;
use SessionHandlerInterface;

class DatabaseSessionHandler implements SessionHandlerInterface
{

    /**
     * @inheritDoc
     */
    public function open($savePath, $sessionName): bool
    {
        return true;
    }

    /**
     * @inheritDoc
     */
    public function close(): bool
    {
        return true;
    }

    /**
     * @inheritDoc
     */
    public function read($id): string
    {
        $record = SessionModel::where('id', $id)
            ->where('expires', '>', time())
            ->first();

        return $record?->data ?? '';
    }

    /**
     * @inheritDoc
     */
    public function write($id, $data): bool
    {
        $expires = time() + (int)ini_get('session.gc_maxlifetime');

        return (bool) SessionModel::updateOrCreate(
            ['id' => $id],
            ['data' => $data, 'expires' => $expires]
        );
    }

    /**
     * @inheritDoc
     */
    public function destroy($id): bool
    {
        return (bool) SessionModel::where('id', $id)->delete();
    }

    /**
     * @inheritDoc
     */
    public function gc($maxLifetime): int|false
    {
        return SessionModel::where('expires', '<', time())->delete();
    }
}