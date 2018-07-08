<?php

return [
    /*
     * 是否啟用整個管理機制
     */
    'enable'               => env('AUTH_MANAGEMENT_ENABLE', false),

    /*
     * 是否開啟用戶單一登入限制
     */
    'single-login'         => env('AUTH_MANAGEMENT_SINGLE_LOGIN', false),

    /*
     * 是否記錄用戶最後活動時間
     */
    'record-last-activity' => env('AUTH_MANAGEMENT_RECORD_LAST', false),

    /*
     * 是否記錄用戶登入/登出事件
     */
    'logging'              => env('AUTH_MANAGEMENT_LOGGING', false),
];
