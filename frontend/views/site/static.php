<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model app\models\ContactForm */

use yii\helpers\Html;
use yii\captcha\Captcha;

$this->title = $page->title;

$this->registerMetaTag([
	'name' => 'description',
	'content' => $page->description
]);
$this->registerMetaTag([
	'name' => 'keywords',
	'content' => $page->keywords
]);

foreach($categories as $category)
{
	$this->params['breadcrumbs'][] = $category;
}

echo '<div class="height-50"></div>';
echo '<h1>' . $page->name . '</h1>';
echo '<article>';
echo $page->text;
echo '</article>';
?>
