<?php

declare(strict_types=1);

namespace Borlotti\Core\Library\Session;

use Borlotti\Core\Library\Session\Database\SessionModel;
use SessionHandlerInterface;

class DatabaseSessionHandler implements SessionHandlerInterface
{

    public function open($savePath, $sessionName): bool
    {
        return true;
    }

    public function close(): bool
    {
        return true;
    }

    public function read($id): string
    {
        $record = SessionModel::where('id', $id)
            ->where('expires', '>', time())
            ->first();

        return $record?->data ?? '';
    }

    public function write($id, $data): bool
    {
        $expires = time() + (int)ini_get('session.gc_maxlifetime');

        return (bool) SessionModel::updateOrCreate(
            ['id' => $id],
            ['data' => $data, 'expires' => $expires]
        );
    }

    public function destroy($id): bool
    {
        return (bool) SessionModel::where('id', $id)->delete();
    }

    public function gc($maxLifetime): int|false
    {
        return SessionModel::where('expires', '<', time())->delete();
    }
}