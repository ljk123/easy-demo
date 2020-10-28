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
`field`用于指定查询字段，不指定默认查询`*`
```php
Container::getInstance()->get('db')->table("user")->field('username,pwd')->select();
//生成sql为 SELECT username,pwd FROM `easy_user`   WHERE 1
```
## where
`where`用于组装查询条件，`可多次调用`，简单支持数组组装`=`逻辑，最外层逻辑只能是`and`其他需求需手写sql  
>这样的设计理由
>- 最外层逻辑只能是`AND`对走索引查询友好
> - 数组只支持`=`逻辑减少记忆难度（以前经常看到有人问怎么组合`between`,`like`啥的问题，为什么要组合，直接写不香吗），其他逻辑可以通过多次调用实现，详情见下例

!>注意，非数组组合语句，必须使用`参数绑定`的方式传入变量
```php
<?php

namespace app\controller;

use easy\Db;

class Index
{

    public function index(Db $db)
    {
        $db->table("user")->where(['username' => 'zhangsan'])->select();
        //生成语句为SELECT * FROM `easy_user`   WHERE username='zhangsan'
        
        $db->table("user")->where('username=:username', ['username' => 'zhangsan'])->select();
        //生成语句为SELECT * FROM `easy_user`   WHERE username='zhangsan'
        
        $db->table("user")->where('username like :username', ['username' => 'zhang%'])->select();
        //生成语句为SELECT * FROM `easy_user`   WHERE username like 'zhang%'
        
        $db->table("user")->where('create_time between :create_time0 and :create_time1', ['create_time0' => 1601049600, 'create_time1' => 1601136000])->select();
        //生成语句为SELECT * FROM `easy_user`   WHERE create_time between 1601049600 and 1601136000
        
        //多次调用where 中间关系为AND
        $db->table("user")
            ->where('username like :username', ['username' => 'zhang%'])
            ->where('create_time between :create_time0 and :create_time1', ['create_time0' => 1601049600, 'create_time1' => 1601136000])
            ->select();
        //生成语句为SELECT * FROM `easy_user`   WHERE username like 'zhang%' AND create_time between 1601049600 and 1601136000

        //可以同一字段多次约束
        $db->table("user")
            ->where('username like :username0', ['username0' => 'zhang%'])
            ->where('username != :username1', ['username1' => 'admin'])//这里需要注意区分两次的username0、username1 否则后面变量会覆盖前面的 导致参数个数不一致
            ->select();
        //生成语句为SELECT * FROM `easy_user`   WHERE username like 'zhang%' AND create_time between 1601049600 and 1601136000
        return;
    }
}
```
## limit
`limit`用于组合`LIMIT`语法，即指定查询和操作的数量  
接受两个参数`offset`,`size`；其中`offset`可以省略，即为0
```php
Container::getInstance()->get('db')->table("user")->limit(10)->select();//省略offset
//生成的sql为 SELECT * FROM `easy_user`   WHERE 1    LIMIT 0,10
Container::getInstance()->get('db')->table("user")->limit(10,20)->select();
//生成的sql为 SELECT * FROM `easy_user`   WHERE 1    LIMIT 10,20
```
## page
`page`用于方便组合`limit ` 
接受两个参数`page`,`size`;`size`默认为`20`
```php
Container::getInstance()->get('db')->table("user")->page(4)->select();//省略size
//生成的sql为 SELECT * FROM `easy_user`   WHERE 1    LIMIT 60,20
Container::getInstance()->get('db')->table("user")->page(4,15)->select();
//生成的sql为 SELECT * FROM `easy_user`   WHERE 1    LIMIT 45,15
```
## order
`order`用于组合`ORDER BY`语法 ，即排序  原样传入
```php
Container::getInstance()->get('db')->table("user")->order('create_time DESC')->select();
//生成的sql为 SELECT * FROM `easy_user`   WHERE 1   ORDER BY create_time DESC 
```
## group
`group`用于组合`GROUP BY`语法 ，即分组  原样传入
```php
Container::getInstance()->get('db')->table("user")->group('group_id')->select();
//SELECT * FROM `easy_user`   WHERE 1 GROUP BY group_id
```
## having
`having`用于组合`HAVING`语法 
```php
Container::getInstance()->get('db')->table("user")->group('group_id')->having('count(id) > 1')->select();
//生成的sql为 SELECT * FROM `easy_user`   WHERE 1 GROUP BY group_id HAVING count(id) > 1
```
# 查询语句
根据前面链式操作组合规则生成查询语句  

?> 所有查询方法最终都是调用的`select()`方法
## select
生成sql并调用`Db::query()`方法,返回二维数组
```php
    $db->table('user')->select();//返回[['username'=>'admin','pwd'=>'xxxxxxxx'',...],['username'=>'admin2','pwd'=>'xxxxxxxx2'',...],...]
```
## find
自动给`sql`加`LIMIT 1`并返回一维数组
```php
    $db->table('user')->find();//返回['username'=>'admin','pwd'=>'xxxxxxxx'',...]
```
## value
查询某一个字段
```php
    $db->table('user')->where(['id'=>1])->value('username');//返回 admin
```

## column
查询某一列字段
```php
    $db->table('user')->where(['id'=>1])->column('username');//返回 ['admin','admin2',...]
```

# 插入语句

?> todo 每天写一点点

## add
## addAll

# 删除语句
# delete

# 模型

