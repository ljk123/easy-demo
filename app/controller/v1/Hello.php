<?php


namespace app\controller\v1;


use easy\Exception;
use easy\Log;

class Hello
{
    public function index()
    {
        return [
            'msg'=>'hello easy-php',
        ];
    }
    public function exception(){
        throw new Exception('exception test');
    }
}