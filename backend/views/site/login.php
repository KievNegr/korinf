<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

$this->title = 'Коринф инжиниринг - европейское оборудование для пищевой промышленности';

$this->registerMetaTag([
    'name' => 'description',
    'content' => 'Продажа, установка и обслуживание европейского пищевого оборудования в Украине, Россие, Казахстане'
    ]);
$this->registerMetaTag([
    'name' => 'keywords',
    'content' => 'Коринф, инжиниринг, пищевое оборудование, revent, kornfeil, polin, oem, agnelli, sarp, padovani, selmi, canol'
    ]);
?>
<!--SLIDER-->
<div class="slider">
    <div class="slide-1 slide" style="background-image: url('images/slider/1.jpg');">
    </div>

    <div class="slide-2 slide" style="background-image: url('images/slider/2.jpg');">
    </div>

    <div class="slide-3 slide" style="background-image: url('images/slider/3.jpg');">
    </div>

    <div class="slide-4 slide" style="background-image: url('images/slider/4.jpg');">
    </div>

    <div class="slide-fade"></div>
</div><!--/slider-->

<div class="block-slider">
    <h1 class="up" style="color: #FFF; font-size: 4em; margin-top: 20px;">Коринф инжиниринг</h1>
    <h3 style="color: #FFF;">Оборудование для эффективного гастробизнеса</h3>
    <div class="search-block">  
        <?php $form = ActiveForm::begin([
            'id' => 'login-form',
            
            'fieldConfig' => [
                'template' => "{label}\n<div class=\"col-lg-3\">{input}</div>\n<div class=\"col-lg-8\">{error}</div>",
                'labelOptions' => ['class' => 'col-lg-1 control-label'],
            ],
        ]); ?>
        <?= $form->field($model, 'username')->textInput(['autofocus' => true, 'placeholder' => 'Login', 'autocomplete' => 'off'])->label('') ?>
        <?= $form->field($model, 'password')->passwordInput(['placeholder' => 'Password', 'autocomplete' => 'off'])->label('') ?>
        <?= $form->field($model, 'rememberMe')->checkbox([
            'template' => "<div class=\"col-lg-offset-1 col-lg-3\">{input} {label}</div>\n<div class=\"col-lg-8\">{error}</div>",
        ]) ?>
        <?= Html::submitButton('Login', ['class' => 'btn btn-primary', 'name' => 'login-button']) ?>
        <?php ActiveForm::end(); ?>
        <div style="clear: both;"></div>
    </div>
</div>
<div class="air"></div>