<?php


namespace app\model;


use easy\Model;
use app\validate\User as UserVaildate;

/**
 * Class User
 * 支持注解验证器
 * @validate \app\validate\User
 * @package app\model
 */
class User extends Model
{
    //构造方法绑定验证器
//    public function __construct(UserVaildate $validate)
//    {
//        parent::__construct($validate);
//    }
}