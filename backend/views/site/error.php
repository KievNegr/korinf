<?php

/* @var $this yii\web\View */
/* @var $name string */
/* @var $message string */
/* @var $exception Exception */

use yii\helpers\Html;
use yii\widgets\Breadcrumbs;

//$this->title = $name;

$this->params['breadcrumbs'][] = [
            'template' => '<li class="active">{link}</li>', //  шаблон для этой ссылки  
            'label' => '404'
        ];
?>

<?php
    if($exception->statusCode == '404'):
?>
    <h1 class="h1 center" style="color: #4b5052; font-size: 20em; margin-top: -70px;">404</h1>
    <h2 class="center" style="font-size: 2.4em; margin: 0 0 20px 0;">Такой страницы не существует</h2>
    <h5 class="center m-0">Начните с <a href="index.html">главной</a></h5>
<?php
    endif;
?>