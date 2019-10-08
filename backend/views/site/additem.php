<?php
/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model app\models\ContactForm */

use app\components\Tags;
use yii\helpers\Html;
use yii\widgets\Breadcrumbs;
use app\components\Category;
use yii\widgets\ActiveForm;

$this->title = 'Новое оборудование';

echo Html::csrfMetaTags();

foreach($breadcrumbs as $bread)
{
    $this->params['breadcrumbs'][] = $bread;
}

/*echo \kato\DropZone::widget([
       'options' => [
       		'url' => Yii::$app->urlManager->createUrl('images'),
           'maxFilesize' => '2',
       ],
       'clientEvents' => [
           'complete' => "function(file){console.log(file)}",
           'removedfile' => "function(file){alert(file.name + ' is removed')}"
       ],
   ]);*/
?>

<article>
	<?php $aform = ActiveForm::begin(['action' => yii::$app->urlManager->createUrl('additem') , 'options' => ['enctype' => 'multipart/form-data']]); ?>
	<?php echo Html::submitButton('Сохранить', ['class' => 'save-button']); ?>
	<p class="edit-p">Sef  (ЧПУ):</p>
	<?php echo $aform->field($form, 'sef')->textInput(['class' => 'edit-input caution'])->label(''); ?>
	<p class="edit-p">Title:</p>
	<?php echo $aform->field($form, 'title')->textInput(['class' => 'edit-input'])->label(''); ?>
	<p class="edit-p">Description:</p>
	<?php echo $aform->field($form, 'description')->textInput(['class' => 'edit-input'])->label(''); ?>
	<p class="edit-p">Keywords:</p>
	<?php echo $aform->field($form, 'keywords')->textInput(['class' => 'edit-input'])->label(''); ?>
	<p class="edit-p">Название (он же H1):</p>
	<?php echo $aform->field($form, 'name')->textInput(['class' => 'edit-input'])->label(''); ?>
	<p class="edit-p">Цена (евро):</p>
	<?php echo $aform->field($form, 'value')->textInput(['class' => 'edit-input'])->label(''); ?>
	<p class="edit-p">Наличие:</p>
	<?php echo $aform->field($form, 'available')->textInput(['class' => 'edit-input'])->label(''); ?>
	<p class="edit-p">Категория: <span class="open-sel-cat">Выбрать категорию</span></p>
	<?php echo $aform->field($form, 'category')->hiddenInput()->label(''); ?>
	<div class="top-block">
		<div class="gallery">
			<div class="index-img">
				<div style="width: 30%;">
					<p class="edit-p">Изображение в списке:</p>
					<?php echo Html::img('', ['class' => 'new-index-img']); ?>
					<?php echo $aform->field($form, 'img')->fileInput(['class' => 'input-file'])->label('Добавить картинку', ['class' => 'new-label-img']); ?>
				</div>
				<div style="width: 70%;">
					<p class="edit-p">Короткое описание в общем списке:</p>
					<?php echo $aform->field($form, 'short_text')->textarea(['class' => 'edit-textarea', 'style' => 'width: 90%; height: 130px;'])->label(''); ?>
				</div>
			</div>
			<p class="edit-p">Изображения галереи:</p>
			<div class="list-new-img-gallery">
				<?php echo $aform->field($form, 'gallery1')->fileInput(['title' => 'gall1', 'class' => 'input-file inp-gall'])->label('Добавить в галерею', ['class' => 'new-gallery-img', 'id' => 'gall1']); ?>
				<?php echo Html::img('', ['class' => 'gall1-new-gallery']); ?>
			</div>
			<div class="list-new-img-gallery">
				<?php echo $aform->field($form, 'gallery2')->fileInput(['title' => 'gall2', 'class' => 'input-file inp-gall'])->label('Добавить в галерею', ['class' => 'new-gallery-img', 'id' => 'gall2']); ?>
				<?php echo Html::img('', ['class' => 'gall2-new-gallery']); ?>
			</div>
			<div class="list-new-img-gallery">
				<?php echo $aform->field($form, 'gallery3')->fileInput(['title' => 'gall3', 'class' => 'input-file inp-gall'])->label('Добавить в галерею', ['class' => 'new-gallery-img', 'id' => 'gall3']); ?>
				<?php echo Html::img('', ['class' => 'gall3-new-gallery']); ?>
			</div>
			<div class="list-new-img-gallery">
				<?php echo $aform->field($form, 'gallery4')->fileInput(['title' => 'gall4', 'class' => 'input-file inp-gall'])->label('Добавить в галерею', ['class' => 'new-gallery-img', 'id' => 'gall4']); ?>
				<?php echo Html::img('', ['class' => 'gall4-new-gallery']); ?>
			</div>
			<div class="list-new-img-gallery">
				<?php echo $aform->field($form, 'gallery5')->fileInput(['title' => 'gall5', 'class' => 'input-file inp-gall'])->label('Добавить в галерею', ['class' => 'new-gallery-img', 'id' => 'gall5']); ?>
				<?php echo Html::img('', ['class' => 'gall5-new-gallery']); ?>
			</div>
			<div class="list-new-img-gallery">
				<?php echo $aform->field($form, 'gallery6')->fileInput(['title' => 'gall6', 'class' => 'input-file inp-gall'])->label('Добавить в галерею', ['class' => 'new-gallery-img', 'id' => 'gall6']); ?>
				<?php echo Html::img('', ['class' => 'gall6-new-gallery']); ?>
			</div>
			<div style="clear: both;"></div>
		</div>
		<div class="info">
			<p class="edit-p">Код:</p>
			<?php echo $aform->field($form, 'code')->textInput(['class' => 'edit-input'])->label(''); ?>
			<p class="edit-p">Краткая информация:</p>
			<?php echo $aform->field($form, 'info')->textarea(['value' => $settings[0]['value'], 'class' => 'edit-textarea'])->label(''); ?>
		</div>
	</div>
	
	<div class="tabs-block">
		<p class="edit-p">Полный текст:</p>
		<?php echo $aform->field($form, 'full_text')->textarea(['value' => $settings[1]['value'], 'class' => 'edit-textarea area-50'])->label(''); ?>
	</div>

	<p class="edit-p">Добавить теги (через запятую):</p>
	
	<?php echo $aform->field($form, 'tags')->textInput(['class' => 'edit-input'])->label(''); ?>
	<?php ActiveForm::end(); ?>
	<?php
		if(!empty($tags)) echo Tags::widget(['tags' => $tags]);
	?>
</article>
<div class="selectCategory">
<div class="selCatClose">×</div>
<h4>Выбрать категорию</h4>
<?php echo Category::widget(['category' => $categories]); ?>
</div>

<?php
$script = <<<JS
	$('html').on('click', '.show', function()
	{
		$('.show').removeClass('bold');
		$(this).addClass('bold');
		$('.selectCategory').fadeOut();
		$('.open-sel-cat').text($(this).text());
		$('#newitem-category').val($(this).attr('id').substr(5));
	});

	$('html').on('click', '.open-sel-cat', function()
	{
		$('.selectCategory').fadeIn();
	});

	$('html').on('click', '.selCatClose', function()
	{
		$('.selectCategory').fadeOut();
	});

    function readURL(input) {
	    if (input.files && input.files[0]) {
	        var reader = new FileReader();
	        
	        reader.onload = function (e) {
	            $('.new-index-img').attr('src', e.target.result);
	            $('.new-index-img').fadeIn(500);
	            $('.new-label-img').addClass('new-label-img-change');
	        }
	        
	        reader.readAsDataURL(input.files[0]);
	    }
    }

    $("#newitem-img").change(function(){
        readURL(this);
    });

    function readGallURL(input) {
	    if (input.files && input.files[0]) {
	        var reader = new FileReader();
	        
	        reader.onload = function (e) {
	            $('.' + input.title + '-new-gallery').attr('src', e.target.result);
	            $('.' + input.title + '-new-gallery').fadeIn(500);
	            $('#' + input.title).html('+').addClass('new-gallery-img-plus');
	        }
	        
	        reader.readAsDataURL(input.files[0]);
	    }
    }

    $(".inp-gall").change(function(){
        readGallURL(this);
    });
    
JS;

$this->registerJs($script);
?>