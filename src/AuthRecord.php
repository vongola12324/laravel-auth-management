<?php

namespace Vongola\Auth;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class AuthRecord
 * @package Vongola\Auth
 * @property int $id
 * @property string $user_type
 * @property int $user_id
 * @property string $user_agent
 * @property string $login_ip
 * @property string $session_id
 * @property Carbon|null $last_activity_at
 * @property Carbon|null $deleted_at
 */
class AuthRecord extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'user_type',
        'user_id',
        'user_agent',
        'login_ip',
        'session_id',
        'last_activity_at',
    ];

    protected $dates = [
        'deleted_at',
        'last_activity_at'
    ];

    public function user()
    {
        return $this->morphTo();
    }
}