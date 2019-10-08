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
	<h4>Вы искали: <?php echo $search; ?></h4>
	<h5 class="h1 center" style="color: #4b5052;">Не нашли то, что искали? </h5>
	<p>Свяжитесь с <a href="<?php echo Yii::$app->urlManager->createUrl(['contacts']);?>">нами</a></p>
	<label for="show-search" class="search-again">или попробуйте еще разок</label>
</article>
