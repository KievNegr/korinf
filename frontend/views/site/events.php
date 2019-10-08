<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model app\models\ContactForm */

use yii\helpers\Html;
use yii\captcha\Captcha;

$this->title = 'Новости компании | Коринф';

$this->registerMetaTag([
	'name' => 'description',
	'content' => 'События компании: Выставки, Новости. Оборудование для пищевой промышленности и гастробизнеса ☎ +38(044)502-44-16'
]);
$this->registerMetaTag([
	'name' => 'keywords',
	'content' => 'События, новости, статьи, коринф инжиниринг, коринф'
]);

$this->params['breadcrumbs'][] = [
	'template' => '<li class="active">{link}</li>',
	'label' => 'События'
];

?>
<div class="height-50"></div>
<h1>События компании</h1>
<article>
<div class="tabs-block">
	<input id="tab1" type="radio" name="tabs" checked>
	<label for="tab1"><span>Выставки</span></label>
	<input id="tab2" type="radio" name="tabs">
	<label for="tab2"><span>Новости</span></label>
	<input id="tab3" type="radio" name="tabs">
	<label for="tab3"><span>Статьи</span></label>
	<section id="content1">
		<?php 
			foreach($pages as $page):
				if($page->category == 1):
		?>
		<div class="block-event">
			<p class="data"><?php echo $page->date; ?></p>
			<div class="descr">
				<p><a href="<?php echo yii::$app->urlManager->createUrl(['page/' . $page->sef]); ?>"><?php echo $page->title; ?></a></p>
				<p><?php echo $page->short_text; ?></p>
			</div>
		</div>
		<?php
				endif;
			endforeach;
		?>
	</section>
	<section id="content2">
		<?php 
			foreach($pages as $page):
				if($page->category == 2):
		?>
		<div class="block-event">
			<p class="data"><?php echo $page->date; ?></p>
			<div class="descr">
				<p><a href="<?php echo yii::$app->urlManager->createUrl(['page/' . $page->sef]); ?>"><?php echo $page->title; ?></a></p>
				<p><?php echo $page->short_text; ?></p>
			</div>
		</div>
		<?php
				endif;
			endforeach;
		?>
	</section>
	<section id="content3">
		<?php 
			foreach($pages as $page):
				if($page->category == 3):
		?>
		<div class="block-event">
			<p class="data"><?php echo $page->date; ?></p>
			<div class="descr">
				<p><a href="<?php echo yii::$app->urlManager->createUrl(['page/' . $page->sef]); ?>"><?php echo $page->title; ?></a></p>
				<p><?php echo $page->short_text; ?></p>
			</div>
		</div>
		<?php
				endif;
			endforeach;
		?>
	</section>
</div>
</article>