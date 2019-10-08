<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model app\models\ContactForm */

use app\components\Tags;
use app\components\Category;
use yii\helpers\Html;
use yii\widgets\Breadcrumbs;


$this->title = $item->title . " в Киеве и Украине | Коринф";

$this->registerMetaTag([
    'name' => 'description',
    'content' => $item->name . ". Характеристики, цена от " . $item->price . " грн, фото. Официальная гарантия. Доставка по Киеву и Украине ☎ +38(044)502-44-16"
]);

foreach($breadcrumbs as $bread)
{
    $this->params['breadcrumbs'][] = $bread;
}

?>
<div class="height-50"></div>

<?php
	
	//if($_SERVER['REMOTE_ADDR'] == '31.128.72.110'):
?>
	
<div class="filter">
    <input type="checkbox" id="open-filter" />
    <label for="open-filter" class="filter-open"></label>
    <?php echo Category::widget(['category' => $categories]); ?>
    <div class="content">
        <div class="content-list" style="margin: 0; padding: 0;">
        	<h1 style="margin: 0px 2% 0;"><?php echo $item->name; ?></h1>
            <div class="top-info">
            	<?php
            		if(count($gallery) == 1):
            	?>
            	<img src="<?php echo $gallery[0]['img']; ?>" class="view-gallery" style="position: static; opacity: 1; transform: scale(1);" />
            	<?php
            		else:
            	?>
				<div class="gallery-item">
					<?php
						$i = 1;
						$checked = 'checked';
						foreach($gallery as $image):
					?>
					<input type="radio" id="gallery_<?php echo $i; ?>" name="r_gallery" <?php echo $checked; ?> />
					<label for="gallery_<?php echo $i; ?>">
						<img src="<?php echo $image->thumbs; ?>" />
					</label>
					<img src="<?php echo $image->img; ?>" class="view-gallery" />
						<div class="view-gallery-title"><?php echo $image->title; ?></div>
					<?php
							$checked = NULL;
							$i++;
						endforeach;
					?>
				</div>
				<?php
					endif;
				?>
				<div class="info">
					<!--<p class="code-item">Код: <?php echo $item->id; ?></p>-->
					<?php echo $item->info; ?>
					<?php
						if($item->price != 0)
						{
							echo Html::beginTag('div', ['class' => 'price']);
							echo number_format($item->price * $this->params['eur'], 2, '.', ' ') . ' грн';
							echo Html::endTag('div');
							switch($item->availability){
								case 0: 
										echo Html::beginTag('div', ['class' => 'price isnt']);
										echo "Нет в наличии";
										echo Html::endTag('div');
										break;
								case 1: 
										echo Html::beginTag('div', ['class' => 'price isnt']);
										echo "Есть в наличии";
										echo Html::endTag('div');
										break;
								case 2: 
										echo Html::beginTag('div', ['class' => 'price maybe', 'id' => '__telerWdTriggerContent']);
										echo "Уточнить наличие";
										echo Html::endTag('div');
										break;
							}
							
						}
						else
						{
							echo Html::beginTag('div', ['class' => 'price']);
							echo 'Цену уточняйте';
							echo Html::endTag('div');
							switch($item->availability){
								case 0: 
										echo Html::beginTag('div', ['class' => 'price isnt']);
										echo "Нет в наличии";
										echo Html::endTag('div');
										break;
								case 1: 
										echo Html::beginTag('div', ['class' => 'price isnt']);
										echo "Есть в наличии";
										echo Html::endTag('div');
										break;
								case 2: 
										echo Html::beginTag('div', ['class' => 'price maybe']);
										echo "Наличие уточняйте";
										echo Html::endTag('div');
										break;
							}
						}
					?>
				</div>
			</div>
			<article>	
				<div class="tabs-block">
					<?php echo $item->full_text; ?>
				</div>

				<?php
					if(count($similar) != 0)
					{
						echo "<h3>Похожие товары</h3>";
						echo "<div class=\"content-list\">";
						foreach($similar as $sGoods)
						{
							if($sGoods->id != $item->id)
							{
								echo Html::beginTag('div', ['class' => 'block-25 center divhover']);
				                echo Html::a(Html::img($sGoods->img, ['alt' => $sGoods->name, 'title' => $sGoods->name]), Yii::$app->urlManager->createUrl(['stat/' . $sGoods->sef]));
				                echo Html::a($sGoods->name, Yii::$app->urlManager->createUrl(['stat/' . $sGoods->sef]), ['class' => 'link-text', 'style' => 'font-size: 1em;']);
				                echo Html::endTag('div');
				            }
						}
						echo "</div>";
					}
				?>
			</article>
			<?php
				if(!empty($tags)) echo Tags::widget(['tags' => $tags]);
			?>
        </div>
    </div>
</div>

<?php
	//else:
?>
<!--<div class="top-info">
	<div class="gallery-item">
		<?php
			$i = 1;
			$checked = 'checked';
			foreach($gallery as $image):
		?>
		<input type="radio" id="gallery_<?php echo $i; ?>" name="r_gallery" <?php echo $checked; ?> />
		<label for="gallery_<?php echo $i; ?>">
			<img src="<?php echo $image->thumbs; ?>" />
		</label>
		<img src="<?php echo $image->img; ?>" class="view-gallery" />
			<div class="view-gallery-title"><?php echo $image->title; ?></div>
		<?php
				$checked = NULL;
				$i++;
			endforeach;
		?>
	</div>
	<div class="info">
		<?php
			if($item->price != 0)
			{
				echo Html::beginTag('div', ['class' => 'price']);
				echo $item->price * $this->params['eur'] . " грн";
				echo Html::endTag('div');
			}
		?>
		<?php echo $item->info; ?>
	</div>
</div>
<article>	
	<div class="tabs-block">
		<?php echo $item->full_text; ?>
	</div>

	<?php
		if(count($similar) != 0)
		{
			echo "<h3>Похожие товары</h3>";
			echo "<div class=\"content-list\">";
			foreach($similar as $sGoods)
			{
				if($sGoods->id != $item->id)
				{
					echo Html::beginTag('div', ['class' => 'block-25 center divhover']);
	                echo Html::a(Html::img($sGoods->img, ['alt' => $sGoods->name, 'title' => $sGoods->name]), Yii::$app->urlManager->createUrl(['stat/' . $sGoods->sef]));
	                echo Html::a($sGoods->name, Yii::$app->urlManager->createUrl(['stat/' . $sGoods->sef]), ['class' => 'link-text', 'style' => 'font-size: 1em;']);
	                echo Html::endTag('div');
	            }
			}
			echo "</div>";
		}
	?>

	<?php
		if(!empty($tags)) echo Tags::widget(['tags' => $tags]);
	?>
</article>-->
<?php
	//endif;
?>
<!--<input id="open-feedback" type="radio" name="feed" />
<label for="open-feedback" class="open-feedback">?</label>
<input id="close-feedback" type="radio" name="feed" checked/>
<label for="close-feedback" class="close-feedback">Закрыть</label>
<div class="feedback" id="feedback">
	<h3>Остались вопросы?</h3>
	<p>Наши специалисты являются экспертами в области оборудования для пищевой промышленности, поэтому вы всегда можете проконсультироваться с ними по вопросам данного оборудования (<?php echo $item->name; ?>).</p>
	<div class="feedback-info">
		<div class="feedback-id">
			<input type="text" name="name" id="name-user" class="input" placeholder="Ваше имя" /><br />
	    	<input type="text" name="phone" id="phone-user" class="input" placeholder="Телефон для связи" />
	    </div>
	    <div class="feedback-quest">
	    	<textarea id="question-user" class="input" placeholder="Ваш вопрос"></textarea>
	    </div>
	</div>
    <input type="button" name="submit" id="sbm-feedback" value="Отправить" />
</div>
<div class="fade-feedback"></div>-->
