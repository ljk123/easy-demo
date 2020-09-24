<?php


namespace app\controller\v1;


class Hello
{
    public function index()
    {
        return [
            'msg'=>'hello easy-php',
        ];
    }
}