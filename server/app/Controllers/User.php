<?php

namespace App\Controllers;

class User extends BaseController
{
    public function login()
    {
        $post_data = $this->request->getPost();
        helper("response");

        if (!isset($post_data["username"]) || $post_data["username"] == "" || $post_data["username"] == NULL) return response_with(400, ["error" => "Kullanıcı adı eksik"]);
        if (!isset($post_data["password"]) || $post_data["password"] == "" || $post_data["password"] == NULL) return response_with(400, ["error" => "Parola adı eksik"]);

        $userModel = model("UserModel");
        $checkUser = $userModel->checkUser($post_data["username"], $post_data["password"]);
        if (count($checkUser) != 1) return response_with(401, ["error" => "Kullanıcı adı veya parola hatalı"]);

        helper("jwt");
        $token = jwt_encode($checkUser[0]);
        return response_with(200, ["token" => $token]);
    }
}
