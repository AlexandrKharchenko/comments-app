<?php


namespace Core\Support;


use Core\Exception\ValidatorException;
use Core\Request;

class Validator
{

    private $dataToValidate;

    private $errors = [];

    private $errorsMessage = [
        'required' => 'Field :field is required',
        'email' => 'Field :field must be valid email',
    ];


    /**
     * Validator constructor.
     */
    public function __construct()
    {
    }


    public function run()
    {

    }

    public function validate($data, $rules = [])
    {

        // Clear errors
        $this->errors = [];

        if ($data instanceof Request) {

            // If exist data from request var
            if (!empty($data->getRequestData())) {
                $this->dataToValidate = $data->getRequestData();
            } // If exist data from php input
            elseif (!empty($data->getInputData())) {
                $this->dataToValidate = $data->getInputData();
            } else {
                $this->dataToValidate = [];
            }

            $this->validation($rules);
        } elseif (is_array($data)) {
            $this->dataToValidate = $data;
            $this->validation($rules);
        } else {
            throw new ValidatorException('Validator wait array or Response object');
        }



        return $this;
    }

    public function isValid()
    {
        return (!$this->errors) ? true : false;
    }

    public function isFail()
    {
        return ($this->errors) ? true : false;
    }

    public function getErrors()
    {
        return $this->errors;
    }

    private function validation($rules)
    {
        foreach ($rules as $key =>  $rule){
            $rulesArray = explode('|' , $rule);

            foreach ($rulesArray as $rule){
                $this->existRuleValidator($rule);

                $res = $this->$rule($key , $rule);

                if($res !== true){
                    $this->errors[$key][] = $res;
                }

            }



        }

        //print_r('<pre>'.(__FILE__).':'.(__LINE__).'<hr />'.print_r( $this->errors ,true).'</pre>');
    }

    private function existRuleValidator($rule){
        if(!method_exists($this ,  $rule)){
            throw new ValidatorException("Rule {$rule} not found.");
        }
    }

    private function required ($key , $value){

        $validation = (isset($this->dataToValidate[$key]) && !empty(trim($this->dataToValidate[$key])));

        if($validation){
            $response = true;
        } else {
            $response = $this->createErrorMessage('required' , $key);
        }

        return $response;
    }


    private function createErrorMessage($rule ,  $field){
        return  [
            "rule" => $rule,
            "message" => str_replace([':field'] , [$field] , $this->errorsMessage[$rule])
        ];
    }

    private function email($key, $value , $required = false)
    {

        // If field not required and field key not found
        if($required === false && $this->required($key , $value) !== true)
            return true;


        $validation = filter_var($this->dataToValidate[$value], FILTER_VALIDATE_EMAIL);

        if($validation){
            $response = true;
        } else {
            $response = $this->createErrorMessage('email' , $key);
        }

        return $response;
    }
}