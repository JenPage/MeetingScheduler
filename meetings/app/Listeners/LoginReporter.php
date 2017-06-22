<?php

namespace App\Listeners;

class LoginReporter{

    /**
     * @hears("UserSentMessage")
     */
    public function handle()
    {
        var_dump('report login');
    }
}

