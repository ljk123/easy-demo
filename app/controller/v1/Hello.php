<?php


namespace app\controller\v1;


use app\model\User;
use easy\App;
use easy\Container;
use easy\Exception;
use easy\Log;
use easy\Validate;

class Hello
{
    public function index(App $app,User $user)
    {
//        $v = new Validate();
//        $v->setAliases([
//            'name'=>'用户名',
//        ])->validate(['name'=>''],[
//            'name'=>'required'
//        ])->isOk();
//        var_dump($v->getErrors());
//        var_dump($app->db->table('user')->where(['id'=>1])->find());
//        var_dump($app->db->getError());
//        var_dump($user->where(['id'=>1])->find());
//        var_dump($user->getError());
        return [
            'msg'=>'hello easy-php',
        ];
    }
    public function exception(){
        throw new Exception('exception test');
    }
}