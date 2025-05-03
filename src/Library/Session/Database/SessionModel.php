<?php

declare(strict_types=1);

namespace Borlotti\Core\Library\Session\Database;

use Illuminate\Database\Eloquent\Model;

class SessionModel extends Model
{
    protected $table = 'sessions';
    protected $primaryKey = 'id';
    public $incrementing = false;
    public $timestamps = false;

    protected $fillable = ['id', 'data', 'expires'];
}