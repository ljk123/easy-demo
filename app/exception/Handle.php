<?php


namespace app\exception;

use easy\Container;
use easy\exception\UserHandleInterface;
use Throwable;

class Handle implements UserHandleInterface
{

    public function report(Throwable $e): bool
    {
//        Container::getInstance()->get('app');
//        Container::getInstance()->get('request');
//        Container::getInstance()->get('response');


//        Container::getInstance()->get('response')->json(['已处理了']);
//        return true;

        return false;//false表示未处理 true表示已处理
    }
}