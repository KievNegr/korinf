<?php

/* @var $this yii\web\View */
/* @var $name string */
/* @var $message string */
/* @var $exception Exception */

use yii\helpers\Html;
use yii\widgets\Breadcrumbs;

$this->title = 'Not Found (#404)';

$this->params['breadcrumbs'][] = [
            'template' => '<li class="active">{link}</li>', //  шаблон для этой ссылки  
            'label' => '404'
        ];
?>
<div class="height-50"></div>
<h1>Такой страницы не существует #404</h1>
<div class="error-div">
<?php
    foreach($categories as $category)
    {
        echo Html::beginTag('div', ['class' => 'error-div-block']);
        echo Html::a($category['name'], Yii::$app->urlManager->createUrl(['equipment/' . $category['sef']]), ['class' => 'link-text']);
        foreach($category['sub'] as $val)
        {
            echo Html::a($val['name'], Yii::$app->urlManager->createUrl(['equipment/' . $val['sef']]), ['class' => 'sub-link-text']);
        }
        echo Html::endTag('div');
    }
?>
</div>