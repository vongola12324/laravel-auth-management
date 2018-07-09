<?php

namespace Vongola\Auth\Services;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Support\Facades\Log;
use Monolog\Logger as MonologLogger;

class LogService
{
    /**
     * The Log levels.
     *
     * @var array
     */
    protected $levels = [
        'debug'     => MonologLogger::DEBUG,
        'info'      => MonologLogger::INFO,
        'notice'    => MonologLogger::NOTICE,
        'warning'   => MonologLogger::WARNING,
        'error'     => MonologLogger::ERROR,
        'critical'  => MonologLogger::CRITICAL,
        'alert'     => MonologLogger::ALERT,
        'emergency' => MonologLogger::EMERGENCY,
    ];

    /**
     * JSON 設定
     * JSON_UNESCAPED_UNICODE 不跳脫Unicode字元
     * JSON_UNESCAPED_SLASHES 不跳脫斜線
     * @var int
     */
    protected static $jsonOptions = JSON_UNESCAPED_UNICODE + JSON_UNESCAPED_SLASHES;

    public function loginLogging(Authenticatable $user)
    {
        $this->logging(
            'debug',
            '[Auth][Login] User (id=' . $user->id . ') has logged in.' . $this->message($user)
        );
    }

    public function logoutLogging(Authenticatable $user)
    {
        $this->logging(
            'debug',
            '[Auth][Logout] User (id=' . $user->id . ') has logged out.' . $this->message($user)
        );
    }

    protected function message(Authenticatable $user)
    {
        return json_encode([
            'user_type' => get_class($user),
            'user_id'   => $user->id,
            'ip'        => request()->ip(),
        ]);
    }

    protected function logging($level, $message)
    {
        //測試環境不處理
        if (app()->environment('testing')) {
            return;
        }
        //只處理有效層級的紀錄
        if (!in_array($level, array_keys($this->levels))) {
            return;
        }

        Log::$level($message);
    }
}
