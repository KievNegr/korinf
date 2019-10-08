<?php

/* @var $this yii\web\View */

use yii\helpers\Html;
use yii\widgets\ActiveForm;

$this->title = 'Currency';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="site-about">
    <h1><?= Html::encode($this->title) ?></h1>
    <article>
	    <p>Текущие значиния курса валют</p>
	    <?php $updForm = ActiveForm::begin(['action' => yii::$app->urlManager->createUrl('curr')]); ?>
		<?php echo $updForm->field($form, 'eur')->textInput(['class' => 'edit-input caution', 'value' => $curr->eur])->label('Eur:'); ?>
		<?php echo $updForm->field($form, 'usd')->textInput(['class' => 'edit-input caution', 'value' => $curr->usd])->label('Usd:'); ?>
		<?php echo $updForm->field($form, 'date')->textInput(['class' => 'edit-input caution', 'value' => $curr->date])->label('Дата:'); ?>
		<?php echo Html::submitButton('Обновить', ['class' => 'save-button']); ?>
		<?php ActiveForm::end(); ?>
	</article>
</div>
