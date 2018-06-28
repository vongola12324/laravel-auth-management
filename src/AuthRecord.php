<?php

namespace Vongola\Auth;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

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
    ];

    public function user()
    {
        return $this->morphTo();
    }
}