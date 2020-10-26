# 控制器定义

控制器放在`app/controller`下,类名和文件名保持大小写一致，并采用`首字母大写驼峰命名`命名文件;方法名采用`首字母小写驼峰命名`。


# 访问
```
http://localhost/v1/user/login 对应的控制器类方法是 app\controller\v1\User::login
http://localhost/index/hello_world 对应的控制器类方法是 app\controller\Index::helloWorld
http://localhost/article_cate/lists 对应的控制器类方法是 app\controller\ArticleCate::lists
```

# 输出
输出控制器是由控制器action方法返给框架，框架执行一次`json_encode`转化为json

>?> 直接返回

```php
<?php

namespace app\controller;

class Hello
{
    public function index()
    {
        return ['hello index'];//输出 ["hello index"]
    }
}
```
>?> 通过抛出`exception\ResponseException`异常来输出

```php
<?php

namespace app\controller;

use easy\exception\ResponseException;

class Hello
{

    public function index()
    {
        throw new ResponseException(['hello index']);//输出 ["hello index"]
    }

}
```
>?> 调用`easy\Response::send`,`easy\Response::json`方法

!> 注意:`easy\Response::json`是调用的`easy\Response::send`方法 整个请求周期只能调用一次`easy\Response::send`,之后的程序可以执行，但是输出会被忽略
```php
<?php

namespace app\controller;

use easy\Response;

class Hello
{

    public function index(Response $response)
    {
        $response->json(['hello index']);//输出 ["hello index"]
    }

}
```




# 前置/后置方法
每个控制器可以定义前置`before`/后置`after`方法，每次请求可通过这些方法执行一些东西

```php
<?php

namespace app\controller;

use easy\Response;

class Hello
{
    protected $data;
    public function before(){
        $this->data=['hello index'];
    }
    public function index(Response $response)
    {
        $response->json($this->data);//输出 ["hello index"]
    }

}
```