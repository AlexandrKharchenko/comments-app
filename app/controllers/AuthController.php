<?php

namespace App\Controllers;

use App\Models\User;
use Core\Facades\ResponseFacade;
use Core\Facades\ViewFacade;
use Core\Mvc\Controller;
use Core\Request;
use Core\Response;
use Core\Support\Auth;

class AuthController extends Controller
{


    /**
     * Controller constructor.
     */
    public function __construct()
    {
        parent::__construct();
    }

    public function index()
    {

    }

    public function showLogin()
    {
        $page = ViewFacade::make('/auth/login', ['user' => 'Hello']);
        $layout = ViewFacade::make('/layouts/main', ['content' => $page]);
        return $layout;
    }

    public function showRegister()
    {
        $page = ViewFacade::make('/auth/register');
        $layout = ViewFacade::make('/layouts/main', ['content' => $page]);
        return $layout;
    }

    public function login(Request $request)
    {

        $validation = $this->validator->validate($request, [
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if($validation->isFail())
            return ResponseFacade::json($validation->getErrors() , 422);


        $userModel = new User();

        $user  = $userModel->select_where(['email' => $request->input('email')]);

        if(!$user){
            return ResponseFacade::json(['email' => [[
                'rule' => 'required',
                'message' => 'Email not found',]
            ]] , 404);
        }

        $userData = $user[0];

        if (password_verify($request->input('password'), $userData['password'])) {

            Auth::login($userData);

            // Success login 200 http response
            return ResponseFacade::json([]);

        } else {
            return ResponseFacade::json(['email' => [[
                'rule' => 'valid',
                'message' => 'Email or Password not valid',]
            ]] , 400);
        }

    }


    public function register(Request $request)
    {

        $validation = $this->validator->validate($request, [
            'first_name' => 'required',
            'last_name' => 'required',
            'email' => 'required|email',
            'password' => 'required',

        ]);



        if($validation->isFail())
            return ResponseFacade::json($validation->getErrors() , 422);

        $userEmail = $request->input('email');

        $userModel = new User;
        $existUser = $userModel->select_where(['email' => $userEmail]);

        if($existUser){
            return ResponseFacade::json(['email' => [[
                'rule' => 'unique',
                'message' => 'Email already in use',]
            ]] , 422);
        }



        $created = $userModel->insert([
            'first_name' => $request->input('first_name'),
            'last_name' => $request->input('last_name'),
            'email' => $request->input('email'),
            'password' => password_hash($request->input('password'), PASSWORD_DEFAULT),
        ]);

        return ResponseFacade::json([] , 201);

    }
}