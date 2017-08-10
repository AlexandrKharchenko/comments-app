<?php

use Core\Router;

Router::get('/' , ['action' => "HomeController@index" , "name" => 'page.home']);

Router::get('/auth/login' , ['action' => "AuthController@showLogin" , "name" => 'auth.login']);

Router::get('/comments' , ['action' => "CommentController@index" , "name" => 'comments.index']);

Router::get('/auth/register' , ['action' => "AuthController@showRegister" , "name" => 'auth.register']);
Router::post('/auth/register' , ['action' => "AuthController@register" , "name" => 'auth.register']);
Router::post('/auth/login' , ['action' => "AuthController@login"]);

