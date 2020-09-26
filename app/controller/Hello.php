<?php


namespace app\controller;


use easy\App;
use easy\utils\Runtime;

class Hello
{
    public function index(){
        return 'hello index';
    }
    public function debugTest(App $app){

        $now=$app->db->query('select now()');
        $memory=Runtime::memory()-$app->begin_memory;
        $time=Runtime::microtime()-$app->begin_time;
        return [
            'now'=>$now,
            'memory'=>round($memory/1024/1024,2).'M',
            'time'=>$time
        ];
    }
}