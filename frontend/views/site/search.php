<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model app\models\ContactForm */

use app\components\Category;
use yii\helpers\Html;
use yii\widgets\Breadcrumbs;

$this->title = $title;

$this->registerMetaTag([
    'name' => 'description',
    'content' => $description
]);

$this->registerMetaTag([
    'name' => 'keywords',
    'content' => $keywords
]);

foreach($breadcrumbs as $bread)
{
    $this->params['breadcrumbs'][] = $bread;
}
?>
<div class="height-50"></div>
<h1>Результаты поиска</h1>           
<article>
    <?php 
        /*if(count($categories) > 0)
        {
            echo '<h4>Поиск по категориям</h4><!--<span style="color: red;">(пока не для всех категорий присвоены картинки)</span>-->';
            echo Html::beginTag('div', ['class' => 'search-list']);
            foreach($categories as $category)
            {
                echo Html::beginTag('div', ['class' => 'block-20 center']);
                echo Html::a(Html::img($category->img, ['alt' => $category->name, 'title' => $category->name]), Yii::$app->urlManager->createUrl(['equipment/' . $category->sef]));
                echo Html::a($category->name, Yii::$app->urlManager->createUrl(['equipment/' . $category->sef]), ['class' => 'link-text', 'style' => 'font-size: 1em;', 'rel' => 'nofollow']);
                echo Html::endTag('div');
            }
            echo Html::endTag('div');
        }*/
        if(count($items) > 0)
        {
            echo '<h4>Поиск по оборудованию</h4>';
            echo Html::beginTag('div', ['class' => 'search-list']);
            foreach($items as $item)
            {
                echo Html::beginTag('div', ['class' => 'block-20 center']);
                echo Html::a(Html::img($item->img, ['alt' => $item->name, 'title' => $item->name]), Yii::$app->urlManager->createUrl(['stat/' . $item->sef]));
                echo Html::a($item->name, Yii::$app->urlManager->createUrl(['stat/' . $item->sef]), ['class' => 'link-text', 'style' => 'font-size: 1em;']);
                echo Html::beginTag('p', ['class' => 'filter-p search-filter-p']);
                echo $item->short_text;
                echo Html::endTag('p');
                echo Html::endTag('div');
            }
            echo Html::endTag('div');
        }
    ?>
<!--
<ul class="search-res">
    <?php
        if(count($categories) > 0)
        {
            foreach($categories as $category)
            {
                echo Html::beginTag('li');
                echo Html::a($category->name, Yii::$app->urlManager->createUrl(['equipment/' . $category->sef]));
                echo Html::endTag('li');
            }
        }

        if(count($items) > 0)
        {
            foreach($items as $item)
            {
                echo Html::beginTag('li');
                echo Html::a($item->name, Yii::$app->urlManager->createUrl(['stat/' . $item->sef]));
                echo Html::endTag('li');
            }
        }
    ?>
</ul>-->
</article>