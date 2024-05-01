<?php

use Firebase\JWT\JWT;
use Firebase\JWT\Key;

if (!function_exists('jwt_encode')) {
    function jwt_encode($data)
    {
        return JWT::encode($data, "bor_task_jwt_key", "HS256");
    }
}

if (!function_exists('jwt_decode')) {
    function jwt_decode($data)
    {
        return JWT::decode($data, new Key("bor_task_jwt_key", "HS256"));
    }
}
