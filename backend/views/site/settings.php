<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model app\models\ContactForm */

use yii\helpers\Html;
use yii\widgets\Breadcrumbs;
use yii\widgets\ActiveForm;

$this->title = 'Настройки сайта';

$this->registerMetaTag([
	'name' => 'description',
	'content' => 'Настройки сайта'
]);

$this->params['breadcrumbs'] = [
    'label' => 'Настройки сайта'
];


?>
<h1>Настройки сайта</h1>
<article>
	<div class="flex">
		<div class="block-50">
			<h4>Настройки главной</h4>
			<?php
				echo '<p>Title:</p>';
				echo Html::input('text', 'title_index', $settings[0]->value);
				echo '<p>Description:</p>';
				echo Html::input('text', 'title_index', $settings[1]->value);
				echo '<p>Keywords:</p>';
				echo Html::input('text', 'title_index', $settings[2]->value);
			?>
		</div>
		<div class="block-50">
			<h4>Настройки главной категорий</h4>
			<?php
				echo '<p>Title:</p>';
				echo Html::input('text', 'title_index', $settings[3]->value);
				echo '<p>Description:</p>';
				echo Html::input('text', 'title_index', $settings[4]->value);
				echo '<p>Keywords:</p>';
				echo Html::input('text', 'title_index', $settings[5]->value);
			?>
		</div>
		<div class="block-50">
			<h4>Настройки главной статических</h4>
			<?php
				echo '<p>Title:</p>';
				echo Html::input('text', 'title_index', $settings[6]->value);
				echo '<p>Description:</p>';
				echo Html::input('text', 'title_index', $settings[7]->value);
				echo '<p>Keywords:</p>';
				echo Html::input('text', 'title_index', $settings[8]->value);
			?>
		</div>
		<div class="block-50">
			<h4>Настройки изображений</h4>
			<?php
				echo '<p>Width категории:</p>';
				echo Html::input('text', 'title_index', $settings[9]->value);
				echo '<p>Height категории:</p>';
				echo Html::input('text', 'title_index', $settings[10]->value);
				echo '<p>Width оборудования:</p>';
				echo Html::input('text', 'title_index', $settings[11]->value);
				echo '<p>Height оборудования:</p>';
				echo Html::input('text', 'title_index', $settings[12]->value);
				echo '<p>Width thumbs галереи оборудования:</p>';
				echo Html::input('text', 'title_index', $settings[13]->value);
				echo '<p>Height thumbs галереи оборудования:</p>';
				echo Html::input('text', 'title_index', $settings[14]->value);
				echo '<p>Width галереи оборудования:</p>';
				echo Html::input('text', 'title_index', $settings[15]->value);
				echo '<p>Height галереи оборудования:</p>';
				echo Html::input('text', 'title_index', $settings[16]->value);
			?>
		</div>
		<div class="block-50">
			<h4>Настройки шаблонов позиций</h4>
			<?php
				echo '<p>Короткий текст:</p>';
				echo Html::textarea('short_text', $settings[17]->value, ['class' => 'edit-textarea']);
				echo '<p>Полный текст:</p>';
				echo Html::textarea('full_text', $settings[18]->value, ['class' => 'edit-textarea']);
			?>
		</div>

		<div class="block-50">
			<h4>Making the sitemap</h4>
			<p>Позиций в базе: <?php echo count($sitemap['items']);?></p>
			<p>Категорий оборудования в базе: <?php echo count($sitemap['category']);?></p>
			<p>Статических страниц в базе: <?php echo count($sitemap['page']);?></p>
			<p>Общее количество страинц <?php echo count($sitemap['items']) + count($sitemap['category']) + count($sitemap['page']) + 1; ?></p>
			<p>Последнее изменение файла: <?php echo ($sitemap['lastMod']);?></p>
			<?php $form = ActiveForm::begin(['action' => yii::$app->urlManager->getBaseUrl()]);?>
			<?php echo Html::SubmitButton('Create a new sitemap', ['name' => 'creatingsitemap', 'class' => 'simple-save-button']);?>
			<?php ActiveForm::end();?>
		</div>
	</div>
</article>