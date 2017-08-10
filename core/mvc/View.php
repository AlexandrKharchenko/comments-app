<?php

namespace Core\Mvc;


use Core\Exception\ViewException;

class View
{
    /**
     * @var array
     */
    private $data = [];
    /**
     * @var
     */
    private $rendered;
    /**
     * @var
     */
    private $page;



    public function make($view , $data = [])
    {
        $viewFileExist = $this->_checkFileExit($view);

        if($viewFileExist === false)
            throw new ViewException("View {$view} not found");

        extract($data);
        ob_start();
            $fileExt = ($viewFileExist === 1) ? 'php' : 'html';
            $fileView = VIEWS_DIR . "/{$view}." . $fileExt;
            include $fileView;
            $rendered = ob_get_contents();
        ob_end_clean();

        return $rendered;

    }

    private function _checkFileExit($path){

        if(file_exists(VIEWS_DIR . '/' . $path . '.php'))
            return 1;
        elseif (file_exists(VIEWS_DIR . '/' . $path . '.html'))
            return 2;
        else
            false;
    }


}