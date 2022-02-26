<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $email = $request->email;
        $password = $request->password;
        $verify_password = $request->verify_password;

        var_dump($email);
        var_dump($password);
        var_dump($verify_password);

    }

    public function register()
    {
        # code...
    }
}