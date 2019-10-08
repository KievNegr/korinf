<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model app\models\ContactForm */

use yii\helpers\Html;
use yii\captcha\Captcha;

$this->title = 'Новости компании «Коринф инжиниринг»';

$this->registerMetaTag([
	'name' => 'description',
	'content' => 'События, новости и статьи компании «Коринф инжиниринг»'
]);


$this->params['breadcrumbs'][] = [
	'template' => '<li class="active">{link}</li>',
	'label' => 'События'
];

?>

<h1>Управление страницами</h1>
<article>
    <div class="flex">
        <div class="block-50">
            <h4>Список страниц</h4>
            <?php
                foreach($pages as $page)
                {
                    if($page->category == NULL) $page->category = '0';
                    echo Html::beginTag('p', ['class' => 'list category_' . $page->category]);
                    echo Html::a(Html::img('/web/images/admin/edit.png', ['width' => '15', 'height' => '15', 'alt' => 'Редактировать', 'title' => 'Редактировать']), yii::$app->urlManager->createUrl(['site/aaa']), ['title' => 'Редактировать', 'class' => 'icon-links']);
                    echo Html::a(Html::img('/web/images/admin/delete.png', ['width' => '15', 'height' => '15', 'alt' => 'Удалить', 'title' => 'Удалить']), yii::$app->urlManager->createUrl(['site/aaa']), ['title' => 'Удалить', 'class' => 'icon-links']);
                    echo Html::a($page->title, yii::$app->urlManager->createUrl(['site/aaa']), ['title' => 'Редактировать', 'class' => 'list-item']);
                    echo Html::endTag('p');
                }
            ?>
        </div>
        <div class="block-50">
            <h4>Список категорий</h4>
            <?php
            	echo Html::beginTag('p', ['style' => 'margin-top: 10px;']);
        		echo Html::a('Статические страницы', yii::$app->urlManager->createUrl(['#']), ['class' => 'list-cat']);
        		echo Html::endTag('p');

            	foreach($categories as $category)
            	{
            		echo Html::beginTag('p', ['style' => 'margin-top: 10px;']);
            		echo Html::a($category->name, yii::$app->urlManager->createUrl(['site/aaa']), ['class' => 'list-cat']);
            		echo Html::a(Html::img('/web/images/admin/edit.png', ['style' => 'margin-left: 10px', 'width' => '15', 'height' => '15', 'alt' => 'Редактировать', 'title' => 'Редактировать']), yii::$app->urlManager->createUrl(['site/aaa']), ['title' => 'Редактировать', 'class' => 'icon-links']);
            		echo Html::endTag('p');
            	}
            ?>
        </div>
    </div>
</article>