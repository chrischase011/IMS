<?php

namespace App\Helpers;

use App\Models\LoginActivity;

class HandleLoginActivity
{
    public static function storeActivity($email, $ip, $useragent, $status)
    {
        LoginActivity::create([
            'email' => $email,
            'ip' => $ip,
            'useragent' => $useragent,
            'status' => $status
        ]);
    }

}
