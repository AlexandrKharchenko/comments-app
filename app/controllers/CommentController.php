<?php

namespace App\Controllers;


use Core\Facades\ViewFacade;
use Core\Mvc\Controller;
use Core\Request;


class CommentController extends Controller
{
    public function __construct()
    {
        parent::__construct();
    }

    public function index(Request $request)
    {
        $page = ViewFacade::make('/comments/index');
        $layout = ViewFacade::make('/layouts/main', ['content' => $page]);
        return $layout;
    }

    public function store(Request $request)
    {
        
    }

    public function getComments(Request $request)
    {

    }
}

