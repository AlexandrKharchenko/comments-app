<?php

namespace App\Controllers;


use App\Models\Comment;
use Core\Facades\ResponseFacade;
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
        print_r('<pre>'.(__FILE__).':'.(__LINE__).'<hr />'.print_r( $request->getInputData() ,true).'</pre>');
        $commentsModel = new Comment();

        $commentsModel->insert([
            'user_id' => 1,
            'parent_id' => 0,
            'comment' => $request->input('comment'),
        ]);
    }

    public function replyToComment(Request $request)
    {
        $commentsModel = new Comment();

        $commentsModel->insert([
            'user_id' => 1,
            'parent_id' => $request->input('parent_id'),
            'comment' => $request->input('comment'),
        ]);
    }

    public function getComments(Request $request)
    {
        $commentsModel = new Comment();

        $comments = $commentsModel->getAllComments();

        $tree = $this->buildTree($comments);

        //print_r('<pre>'.(__FILE__).':'.(__LINE__).'<hr />'.print_r( $tree ,true).'</pre>');

        return ResponseFacade::json($tree);
    }

    private function buildTree(array &$elements, $parentId = 0) {
        $branch = array();

        foreach ($elements as $element) {
            if ($element['parent_id'] == $parentId) {
                $children = $this->buildTree($elements, $element['id']);
                if ($children) {
                    $element['children'] = $children;
                }
                $branch[$element['id']] = $element;
                unset($elements[$element['id']]);
            }
        }
        return $branch;
    }
}

