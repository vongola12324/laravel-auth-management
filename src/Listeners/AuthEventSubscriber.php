<?php
/**
 * Created by PhpStorm.
 * User: vongola12324
 * Date: 2018/6/28
 * Time: 下午4:59
 */

namespace Vongola\Auth\Listeners;


use Illuminate\Auth\Events\Login;
use Illuminate\Auth\Events\Logout;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Foundation\Auth\User;
use Vongola\Auth\AuthRecord;
use Vongola\Auth\Services\AuthService;
use Vongola\Auth\Services\LogService;

class AuthEventSubscriber
{
    protected $authService, $logService;

    public function __construct(AuthService $authService, LogService $logService)
    {
        $this->authService = $authService;
        $this->logService = $logService;
    }

    /**
     * Handle user login events.
     * @param Login $event
     */
    public function onUserLogin(Login $event)
    {
        /** @var Authenticatable|User $user */
        $user = $event->user;
        $manager = $this->authService->user($user);
        if (config('auth-management.single-login')) {
            if ($manager->hasOtherLogin()) {
                $manager->forceLogoutOthers();
            };
        }
        $record = AuthRecord::create([
            'user_type'        => get_class($user),
            'user_id'          => $user->getKey(),
            'user_agent'       => request()->userAgent(),
            'login_ip'         => request()->getClientIp(),
            'session_id'       => encrypt(session()->getId()),
            'last_activity_at' => null,
        ]);
        if (config('auth-management.logging')) {
            $this->logService->loginLogging($user);
        }
    }

    /**
     * Handle user logout events.
     * @param Logout $event
     */
    public function onUserLogout(Logout $event)
    {
        /** @var Authenticatable|User $user */
        $user = $event->user;
        $manager = $this->authService->user($user);
        AuthRecord::where('user_type', '=', get_class($user))
            ->where('user_id', '=', $user->getKey())
            ->where('session_id', '=', session()->getId())
            ->delete();
        if (config('auth-management.logging')) {
            $this->logService->loginLogging($user);
        }
    }

    /**
     * Register the listeners for the subscriber.
     *
     * @param  \Illuminate\Events\Dispatcher $events
     */
    public function subscribe($events)
    {
        $events->listen(
            'Illuminate\Auth\Events\Login',
            'App\Listeners\AuthEventSubscriber@onUserLogin'
        );

        $events->listen(
            'Illuminate\Auth\Events\Logout',
            'App\Listeners\AuthEventSubscriber@onUserLogout'
        );
    }
}
