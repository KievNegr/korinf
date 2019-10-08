<?php
$lowerURI=strtolower($_SERVER['REQUEST_URI']);

if($_SERVER['REQUEST_URI']!=$lowerURI)
{
	header("HTTP/1.1 301 Moved Permanently");
	header("Location: http://" . $_SERVER['HTTP_HOST'] . $lowerURI);
	exit();
}

defined('YII_DEBUG') or define('YII_DEBUG', false);
defined('YII_ENV') or define('YII_ENV', 'dev');

require(__DIR__ . '/../../vendor/autoload.php');
require(__DIR__ . '/../../vendor/yiisoft/yii2/Yii.php');
require(__DIR__ . '/../../common/config/bootstrap.php');
require(__DIR__ . '/../config/bootstrap.php');

$config = yii\helpers\ArrayHelper::merge(
    require(__DIR__ . '/../../common/config/main.php'),
    require(__DIR__ . '/../../common/config/main-local.php'),
    require(__DIR__ . '/../config/main.php'),
    require(__DIR__ . '/../config/main-local.php')
);

(new yii\web\Application($config))->run();
