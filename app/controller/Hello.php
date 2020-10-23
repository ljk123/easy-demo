<?php


namespace app\controller;


use easy\App;

class Hello
{
    public function index(App $app)
    {
        return ['hello index'];
    }
}