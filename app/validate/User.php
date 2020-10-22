<?php


namespace app\validate;


use easy\Validate;

class User extends Validate
{
    protected $rule = [
        'sfz' => 'required|id_card'
    ];
    protected $alias = [
        'sfz' => '身份证'
    ];
    protected $msgs = [
        'id_card' => ':attribute不是正确的省份证格式 优先级更高'
    ];

    //自有的验证规则
    protected function rules()
    {
        return [
            'id_card' => [
                'msg' => ':attribute不是正确的省份证格式',
                'fn' => function ($value) {
                    return false;
                }
            ]];
    }
}