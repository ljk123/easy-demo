<?php


namespace app\controller;


use easy\App;
use easy\utils\Runtime;

class Hello
{
    public function index(App $app){
        return ['hello index'];
    }
    public function debugTest(App $app){

        $now=$app->db->query('select now()');
        $cache=$app->cache->get('aaa');
        $memory=Runtime::memory()-$app->begin_memory;
        $time=Runtime::microtime()-$app->begin_time;
        return [
            'db'=>$now,
            'cache'=>$cache,
            'memory'=>round($memory/1024/1024,2).'M',
            'time'=>$time
        ];
    }
}