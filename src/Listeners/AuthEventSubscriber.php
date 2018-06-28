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
use Vongola\Auth\AuthRecord;
use Vongola\Auth\Services\AuthService;

class AuthEventSubscriber
{
    protected $authService;

    public function __construct(AuthService $authService)
    {
        $this->authService = $authService;
    }

    /**
     * Handle user login events.
     */
    public function onUserLogin(Login $event)
    {
        $user = $event->user;
        $manager = $this->authService->user($user);
        if (config('auth-management.single-login')) {
            if ($manager->hasOtherLogin()) {
                $manager->forceLogoutOthers();
            };
        }
        AuthRecord::create([
            'user_type'  => get_class($user),
            'user_id'    => $user->getKey(),
            'user_agent' => request()->userAgent() ,
            'login_ip'   => request()->getClientIp(),
            'session_id' => encrypt(session()->getId()),
            'last_activity_at' => null,
        ]);
    }

    /**
     * Handle user logout events.
     */
    public function onUserLogout(Logout $event)
    {
        $user = $event->user;
        $manager = $this->authService->user($user);
        AuthRecord::where('user_type', '=', get_class($user))
            ->where('user_id', '=', $user->getKey())
            ->where('session_id', '=', session()->getId())
            ->delete();
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
            'App\Listeners\UserEventSubscriber@onUserLogin'
        );

        $events->listen(
            'Illuminate\Auth\Events\Logout',
            'App\Listeners\UserEventSubscriber@onUserLogout'
        );
    }
}