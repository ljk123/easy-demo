# 链接数据库
框架只实现了mysql数据库的适配（大多数情况也只用得上mysql），如需链接数据库，必须配置链接信息,参见[配置文件](config.md#数据库配置)

# 原始查询
框架底层只提供`query`,`execute`+事务系列`startTrans`,`rollback`,`commit`方法  
程序调用是通过DB类来调用，Db类提供简单掉[链式调用](database#链式调用)
```php
<?php

namespace app\controller\admin;

use easy\App;
use easy\Container;
use easy\Db;

class Index
{

    /**
     * 提供多种调用db事例
     */
    public function index(App $app, Db $db)
    {
        //容器获取事例
        $query_by_container = Container::getInstance()->get('db')->query("select now() as query_by_container_time");
        //注入app类获取事例
        $query_by_app = $app->db->query("select now() as query_by_app_time");
        //直接注入db类事例
        $query_by_db = $db->query("select now() as query_by_db_time");
        return compact('query_by_container', 'query_by_app', 'query_by_db');
    }
}
```
>上例输出
```json
{
	"query_by_container": [{
		"query_by_container_time": "2020-09-26 16:50:50"
	}],
	"query_by_app": [{
		"query_by_app_time": "2020-09-26 16:50:50"
	}],
	"query_by_db": [{
		"query_by_db_time": "2020-09-26 16:50:50"
	}]
}
```

# 链式调用
> Db类提供`table`,`alias`,`join`,`field`,`where`,`limit`,`page`,`order`,`group`,`having`链式操作，用于组装sql  

## table
`table`方法主要用于指定操作的数据表。`注意：传入参数不包含前缀`  
```php
Container::getInstance()->get('db')->table('user')->select();
```
## alias
`alias`用于设置当前数据表的别名，便于使用其他的连贯操作例如`join`方法等。
```php
Container::getInstance()->get('db')->table('user')->alias('u')->select();
//生成的sql为 SELECT * FROM `easy_user` u  WHERE 1
```
## join
`join`用于组装JOIN系列语句，`注意：传入参数不包含前缀`    
参数为(`table`表名,`alias`别名,`on`条件,`type`类型`left`,`right`,`inner`[默认`left`])
```php
Container::getInstance()->get('db')->table("user")->alias('u')->join('group', 'g', 'g.id=u.group_id')->select();
//生成的sql为 SELECT * FROM `easy_user` u LEFT JOIN `easy_group` g on g.id=u.group_id  WHERE 1
```
## field
哎明天继续写
# 模型

