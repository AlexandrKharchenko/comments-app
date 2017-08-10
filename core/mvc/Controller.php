<?php

namespace Core\Mvc;

use Core\Support\Validator;

class Controller {

    public $validator;

    /**
     * Controller constructor.
     */
    public function __construct()
    {
        $this->validator = new Validator();
    }
}