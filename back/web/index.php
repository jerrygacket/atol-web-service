<?php

header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Credentials: true');
header('Access-Control-Allow-Headers: x-auth'); // тут заголовки которые отправляются серверу, в данном случаи токены
header('Access-Control-Request-Headers: *');
header('Access-Control-Request-Method: GET, POST, PUT, PATCH, DELETE, HEAD, OPTIONS');
header('Access-Control-Max-Age: 86400');

// comment out the following two lines when deployed to production
defined('YII_DEBUG') or define('YII_DEBUG', true);
defined('YII_ENV') or define('YII_ENV', 'dev');

require __DIR__ . '/../vendor/autoload.php';
require __DIR__ . '/../vendor/yiisoft/yii2/Yii.php';

$config = require __DIR__ . '/../config/web.php';

(new yii\web\Application($config))->run();
