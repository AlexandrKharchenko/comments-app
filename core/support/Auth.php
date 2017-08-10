<?php


namespace Core\Support;


use App\Models\Session;

class Auth
{
    public static function login(array  $user){
        $time = time()+3600*6;
        setcookie("is_login", true, $time);
        setcookie("user_id", $user['id'], $time);
        setcookie("session_id", session_id(), $time);

        $sessionModel = new Session();

        $sessionModel->insert([
            'user_id' => $user['id'],
            'session_id' => session_id(),
            'ip' => $_SERVER['REMOTE_ADDR'],
            'exp' => $time
        ]);

    }
}