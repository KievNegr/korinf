<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model app\models\ContactForm */

use yii\helpers\Html;
use yii\widgets\Breadcrumbs;

$this->title = 'Управление тегами';

$this->registerMetaTag([
    'name' => 'description',
    'content' => 'Управление тегами'
]);

foreach($breadcrumbs as $bread)
{
    $this->params['breadcrumbs'][] = $bread;
}
?>

<h1>Управление тегами</h1>			
<article>
<?php
	foreach($tags as $tag)
	{
		echo '<p>' . $tag->tag_name . '</p>';
	}
?>
</article>
