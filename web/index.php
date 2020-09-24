<?php
namespace easy;

require __DIR__ . '/../vendor/autoload.php';

$app=new App();
//swoole
//$app->set('request',$request);
//$app->set('response',$response);
$app->run();
