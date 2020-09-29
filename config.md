# 公共配置

>```
>[
>   'app_debug'=>true,//开发模式
>    'config_files'=>[//需要添加自动加载的配置文件
>        //file=>name //文件路径=>配置名称 路径首先查找 app/config目录
>    ],
>    'exception_handle'=>null, //自定义异常处理文件 如\app\exception\Handle::class 该类需要实现easy\exception\UserHandleInterface接口 否者不生效
>]
>```

# 缓存配置
>```
[
    'type'=>'redis',
    'prefix'=>'easy_',//前缀
    'expire'=>7200,
];
```