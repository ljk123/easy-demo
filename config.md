# 公共配置

>```
>[
>   'app_debug' => true,//开发模式
>    'config_files' => [//需要添加自动加载的配置文件
>        //file => name //文件路径=>配置名称 路径首先查找 app/config目录
>    ],
>    'exception_handle' => null, //自定义异常处理文件 如\app\exception\Handle::class 该类需要实现easy\exception\UserHandleInterface接口 否者不生效
>]
>```

# 缓存配置
>```
>[
>    'type' => 'redis', //缓存驱动 暂时只有redis
>    'prefix' => 'easy_',//缓存前缀
>    'expire' => 7200,//默认缓存过期时间
>]
>```

# 数据库配置
>```
>[
>    // 服务器地址
>    'host' => '127.0.0.1',//逗号分割 多个表示主从第一个是主库其他是从库
>    // 数据库名
>    'database' =>'easy_mt234_cn',//主从的话逗号必须跟host对应 否者表示相同密码
>    // 用户名
>    'username' => 'easy_mt234_cn',//同上
>    // 密码
>    'password' => 'hwrwNXcKsK2s58eS',//同上
>    // 端口
>    'port' => 3306,//同上
>    // 数据库连接参数
>    'options' => [],
>    // 数据库编码默认采用utf8
>    'charset' => 'utf8mb4',
>    // 数据库表前缀
>    'prefix' => 'easy_',
>]
>```

# 日志配置
>```[
>    'level' => //要记录日志的级别
>        \easy\Log::DEBUG |
>        \easy\Log::INFO |
>        \easy\Log::NOTICE |
>        \easy\Log::WARNING |
>        \easy\Log::ERROR,
>    'onlog' => null,//传入callback 记录日志时出发的回调 用于用户管理日志比如推送到日志中心
>]
>```

# redis配置
>```
>[
>    // 服务器地址
>    'host' => '127.0.0.1',//逗号分割 多个表示主从第一个是主库其他是从库
>    // 数据库名
>    'db' =>'1',//主从的话逗号必须跟host对应 否者表示相同密码
>    // 密码
>    'password' => 'ljk2fxf',//同上
>    // 端口
>    'port' => 6379,//同上
>    //链接超时时间
>    'timeout' => 5,
>]
>```

# swoole配置
>```
>[
>    'server' => [
>        'reactor_num' => 1,     // 设置启动的 Reactor 线程数。【默认值：CPU 核数】
>        'worker_num' => 1,     // 设置启动的 Worker 进程数。【默认值：CPU 核数】
>        'max_request' => 0,      //设置 worker 进程的最大任务数。【默认值：0 即不会退出进程】
>        'dispatch_mode' => 2,   //数据包分发策略。【默认值：2】 //https://wiki.swoole.com/#/server/setting?id=dispatch_mode
>        //更多服务器配置查看 https://wiki.swoole.com/#/server/setting?id=%e9%85%8d%e7%bd%ae
>    ],
>    'http' => [
>        'host' => '127.0.0.1',
>        'port' => 9599,
>    ],
>    'mysql'=>[
>        'pool' => true,//是否起用连接池
>        'name' => 'mysql',//区别连接池的标示
>        'min_size' => 20,//每个进程启动链接数量
>        'max_size' => 100,//最大连接数
>        'free_time' => 600,//空闲时间
>        'timeout' => 1,//获取连接池超时时间
>    ],
>    'redis'=>[
>        'pool' => true,//是否起用连接池
>        'name' => 'redis',//区别连接池的标示
>        'min_size' => 20,//每个进程启动链接数量
>        'max_size' => 100,//最大连接数
>        'free_time' => 600,//空闲时间
>        'timeout' => 1,//获取连接池超时时间
>    ],
>]
>```
