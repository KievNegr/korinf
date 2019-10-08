<?php 

namespace app\components;

use Yii;

use yii\base\Widget;
use yii\helpers\Html;

class Category extends Widget 
{
	public $category; //Получаем сформировавшийся массив меню категорий
	public $selId;

	public function run()
	{
		$viewCategory = Array(); //Создаем массив для вывода в виджет
		foreach($this->category as $category) //Начинаем переборку массива
	    {
	        if(!isset($category[2])) //Если у нас нету вложеных субкатегорий то просто выводим родительские категории
	        {
	            if(isset($this->selId))
	            {
	            	if($this->selId == $viewCategory[0])
	            	{
		            	$viewCategory[] = Html::beginTag('p', ['class' => 'list-cat show bold', 'id' => 'show-' . $category[0], 'style' => 'margin-top: 10px;']) . $category[1] . Html::endTag('p') . Html::beginTag('div', ['style' => 'clear: both;']) . Html::endTag('div');
					}
					else
					{
						$viewCategory[] = Html::beginTag('p', ['class' => 'list-cat show', 'id' => 'show-' . $category[0], 'style' => 'margin-top: 10px;']) . $category[1] . Html::endTag('p') . Html::beginTag('div', ['style' => 'clear: both;']) . Html::endTag('div');
					}
				}
				else 
				{
					$viewCategory[] = Html::beginTag('p', ['style' => 'margin-top: 10px;']) . Html::a($category[1], '#', ['class' => 'list-cat show', 'id' => 'show-' . $category[0]]) . Html::a(Html::img('/admin/images/admin/edit.png', ['width' => '15', 'height' => '15', 'alt' => 'Редактировать', 'title' => 'Редактировать']), yii::$app->urlManager->createUrl(['site/aaa']), ['title' => 'Редактировать', 'class' => 'icon-links']) . Html::endTag('p');
				}
	        }
	        else //Если есть вложеные категории
	        {
	            $tempSubList = NULL; //Создаем переменную для переборки вложеных категорий

	            if(is_array($category[2])) //Если мы имеем во вложеной категории еще вложения то перебираем их
	            {
	            	$tempSubList = '<ul class="list-ul">';
	            	$tempSubList .= $this->eachSubCategory($category[2]); //Идем к цели рекурсией
	            	$tempSubList .= '</ul>';
	            }
	            
	            if(isset($this->selId))
	            {
	            	if($this->selId == $category[0])
	            	{
		            	$viewCategory[] = Html::beginTag('p', ['class' => 'list-cat show bold', 'id' => 'show-' . $category[0], 'style' => 'margin-top: 10px;']) . $category[1] . Html::endTag('p') . $tempSubList;
					}
					else
					{
						$viewCategory[] = Html::beginTag('p', ['class' => 'list-cat show', 'id' => 'show-' . $category[0], 'style' => 'margin-top: 10px;']) . $category[1] . Html::endTag('p') . $tempSubList;
					}
				}
				else 
				{
					$viewCategory[] = Html::beginTag('p', ['style' => 'margin-top: 10px;']) . Html::a($category[1], '#', ['class' => 'list-cat show', 'id' => 'show-' . $category[0]]) . Html::a(Html::img('/admin/images/admin/edit.png', ['width' => '15', 'height' => '15', 'alt' => 'Редактировать', 'title' => 'Редактировать']), yii::$app->urlManager->createUrl(['site/aaa']), ['title' => 'Редактировать', 'class' => 'icon-links']) . Html::endTag('p') . $tempSubList;
				}
	        }
	    }
	    return $this->render('category', [
			'categories' => $viewCategory
		]);
	}

	private function eachSubCategory($listCategory)
	{
		$temp = NULL;
		
		foreach($listCategory as $category)
		{
			if(isset($this->selId))
            {
            	if($this->selId == $category[0])
            	{
	            	if(!isset($category[2]))
					{
						$temp .= '<li><span class = "list-cat show bold" id = "show-' . $category[0] . '">' . $category[1] . '</span></li>';
					}
					else
					{
						$temp .= '<span class = "list-cat show bold" id = "show-' . $category[0] . '">' . $category[1] . '</span>';
						$temp .= '<ul>';
						$temp .= $this->eachSubCategory($category[2]);
						$temp .= '</ul></li>';
					}
				}
				else
				{
					if(!isset($category[2]))
					{
						$temp .= '<li><span class = "list-cat show" id = "show-' . $category[0] . '">' . $category[1] . '</span></li>';
					}
					else
					{
						$temp .= '<li><span class = "list-cat show" id = "show-' . $category[0] . '">' . $category[1] . '</span>';
						$temp .= '<ul>';
						$temp .= $this->eachSubCategory($category[2]);
						$temp .= '</ul></li>';
					}
				}
			}
			else 
			{
				if(!isset($category[2]))
				{
					$temp .= '<li>' . Html::a($category[1], '#', ['class' => 'list-cat show', 'id' => 'show-' . $category[0]]) . Html::a(Html::img('/admin/images/admin/edit.png', ['style' => 'margin-left: 10px', 'width' => '15', 'height' => '15', 'alt' => 'Редактировать', 'title' => 'Редактировать']), yii::$app->urlManager->createUrl(['site/aaa']), ['title' => 'Редактировать', 'class' => 'icon-links']) . '</li>';
				}
				else
				{
					$temp .= '<li>' . Html::a($category[1], '#', ['class' => 'list-cat show', 'id' => 'show-' . $category[0]]) . Html::a(Html::img('/admin/images/admin/edit.png', ['style' => 'margin-left: 10px', 'width' => '15', 'height' => '15', 'alt' => 'Редактировать', 'title' => 'Редактировать']), yii::$app->urlManager->createUrl(['site/aaa']), ['title' => 'Редактировать', 'class' => 'icon-links']);
					$temp .= '<ul>';
					$temp .= $this->eachSubCategory($category[2]);
					$temp .= '</ul></li>';
				}
			}
		}

		return $temp;
	}
}