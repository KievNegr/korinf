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
        <?php 
            $form = ActiveForm::begin(['method' => 'get', 'action' => ['search/'],]);
            echo '<input type="text" placeholder="Login" autocomplete="off" name="login" >';
            echo '<input type="text" placeholder="Password" autocomplete="off" name="password" >';

            echo Html::submitButton('Вход', ['id' => 'btn-search']);

            ActiveForm::end();
        ?>
        <div style="clear: both;"></div>
    </div>
</div>
<div class="air"></div>
<!--/SLIDER-->