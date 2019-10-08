<?php
/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model app\models\ContactForm */

use app\components\Tags;
use yii\helpers\Html;
use yii\widgets\Breadcrumbs;
use app\components\Category;
use yii\widgets\ActiveForm;

$this->title = 'Новая категория';

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
	<?php $aform = ActiveForm::begin(['action' => yii::$app->urlManager->createUrl('addcategory') , 'options' => ['enctype' => 'multipart/form-data']]); ?>
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
	<p class="edit-p">Родительская категория: <span class="open-sel-cat">Выбрать родительскую категорию</span></p>
	<?php echo $aform->field($form, 'category')->hiddenInput(['value' => '0'])->label(''); ?>

	<div class="cat-block">
		<div class="cat-img">
			<p class="edit-p">Изображение Категории:</p>
			<?php echo Html::img('', ['class' => 'new-index-img']); ?>
			<?php echo $aform->field($form, 'img')->fileInput(['class' => 'input-file'])->label('Добавить картинку', ['class' => 'new-label-img']); ?>
		</div>
		<div class="info">
			<p class="edit-p">Короткое описание категории:</p>
			<?php echo $aform->field($form, 'short_text')->textarea(['class' => 'edit-textarea'])->label(''); ?>
		</div>
		<div class="f-text">
			<p class="edit-p">Полный текст категории:</p>
			<?php echo $aform->field($form, 'full_text')->textarea(['class' => 'edit-textarea', 'value' => '<p></p>'])->label(''); ?>
		</div>
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
<p style="margin-top: 10px;">
	<a id="show-0" class="list-cat show" href="#">Сброс</a>
</p>
<?php echo Category::widget(['category' => $categories]); ?>
</div>

<?php
$script = <<<JS
	$('html').on('click', '.show', function()
	{
		$('.show').removeClass('bold');
		$(this).addClass('bold');
		$('.selectCategory').fadeOut();
		if($(this).attr('id').substr(5) != 0)
		{
			$('.open-sel-cat').text($(this).text());
		}
		else
		{
			$('.open-sel-cat').text('Выбрать родительскую категорию');
		}
		$('#newcategory-category').val($(this).attr('id').substr(5));
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

    $("#newcategory-img").change(function(){
        readURL(this);
    });
JS;

$this->registerJs($script);
?>