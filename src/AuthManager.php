<?php

namespace Vongola\Auth;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Cache;

class AuthManager
{
    /** @var Authenticatable $records */
    protected $user;
    /** @var Collection $records */
    protected $records;

    public function __construct(Authenticatable $user)
    {
        $this->user = $user;
        $this->records = AuthRecord::where('user_type', '=', get_class($this->user))
            ->where('user_id', '=', $this->user->getKey())->get();
    }

    public function getAuthRecord()
    {
        return $this->records;
    }

    public function hasOtherLogin()
    {
        return $this->records->count() > 1;
    }

    public function forceLogoutOthers()
    {
        $current = session()->getId();
        foreach ($this->records as $record) {
            $sid = decrypt($record->session_id);
            if ($sid === $current) {
                continue;
            } else {
                try {
                    Cache::flush($sid);
                } catch (\Exception $e) {
                    // Do nothing...
                } finally {
                    $record->delete();
                }
            }
        }
    }
}
