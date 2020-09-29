<?php
return[
    'http'=>[
        'host'=>'127.0.0.1',
        'port'=>9599,
    ],
    'mysql'=>[
        'pool'=>true,//是否起用连接池
        'name'=>'mysql',//区别连接池的标示
        'min_size'=>20,//每个进程启动链接数量
        'max_size'=>100,//最大连接数
        'free_time'=>600,//空闲时间
        'timeout'=>1,//获取连接池超时时间
    ],
    'redis'=>[
        'pool'=>true,//是否起用连接池
        'name'=>'redis',//区别连接池的标示
        'min_size'=>20,//每个进程启动链接数量
        'max_size'=>100,//最大连接数
        'free_time'=>600,//空闲时间
        'timeout'=>1,//获取连接池超时时间
    ],
];