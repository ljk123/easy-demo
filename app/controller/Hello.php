<?php


namespace app\controller;


use app\model\User;
use easy\App;
use easy\utils\Runtime;
use easy\Validate;

class Hello
{
    public function index(App $app)
    {
        return ['hello index'];
    }

    public function debugTest(App $app)
    {
        $now = $app->db->query('select now()');
        $cache = $app->cache->get('aaa');
        $memory = Runtime::memory() - $app->begin_memory;
        $time = Runtime::microtime() - $app->begin_time;
        return [
            'db' => $now,
            'cache' => $cache,
            'memory' => round($memory / 1024 / 1024, 2) . 'M',
            'time' => $time
        ];
    }

    public function validate(User $user)
    {
        var_dump($user->validate(['sfz' => '6487y7ysd']), $user->getError());
        $valid = new Validate();
        return $valid->setAliases(['username' => '用户名'])
            ->setMessages(['between' => "between撒打算打底衫"])
//            ->rule(['username' => 'required|min_len:2|max_len:3|between:10,999|stop', 'username2' => 'required|min_len:2|max_len:3|between:10,999',])
            ->validate(['username' => 1],['username' => 'required|min_len:2|max_len:3|between:10,999|stop', 'username2' => 'required|min_len:2|max_len:3|between:10,999',],true)
            ->isOk() ? 'ok' : $valid->getError();
    }
}