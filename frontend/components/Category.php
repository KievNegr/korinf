<?php 

namespace app\components;

use Yii;

use yii\base\Widget;
use yii\helpers\Html;

class Category extends Widget 
{
	public $category; //Получаем сформировавшийся массив меню категорий

	public function run()
	{
		$viewCategory = Array(); //Создаем массив для вывода в виджет
		foreach($this->category as $category) //Начинаем переборку массива
	    {
	        $active = '';
	        if(!is_array($category)) //Если у нас нету вложеных субкатегорий то просто выводим родительские категории
	        {
	            $viewCategory[] = Html::a($category->name, Yii::$app->urlManager->createUrl(['equipment/' . $category->sef]), ['class' => 'sidebar-menu']);
	        }
	        else //Если есть вложеные категории
	        {
	            if($category['active'] == TRUE) $active = ' active'; //Если категория активна (выбрана)
	            
	            $tempSubList = NULL; //Создаем переменную для переборки вложеных категорий

	            if(is_array($category['sub'])) //Если мы имеем во вложеной категории еще вложения то перебираем их
	            {
	            	$tempSubList = '<ul class="filter-ul">';
	            	$tempSubList .= $this->eachSubCategory($category['sub']); //Идем к цели рекурсией
	            	$tempSubList .= '</ul>';
	            }
	            
	            $viewCategory[] = Html::a($category['name'], Yii::$app->urlManager->createUrl(['equipment/' . $category['sef']]), ['class' => 'sidebar-menu' . $active]) . $tempSubList;

	        }
	    }
		return $this->render('category', [
			'categories' => $viewCategory
		]);
	}

	private function eachSubCategory($listCategory)
	{
		$temp = NULL;
		$active = NULL;

		foreach($listCategory as $category)
		{
			if($category['active'] == TRUE) $active = 'sidebar-subactive';

			if(!is_array($category['sub']))
			{
				$temp .= '<li>' . Html::a($category['name'], Yii::$app->urlManager->createUrl(['equipment/' . $category['sef']]), ['class' => $active]) . '</li>';
			}
			else
			{
				$temp .= '<li>' . Html::a($category['name'], Yii::$app->urlManager->createUrl(['equipment/' . $category['sef']]), ['class' => $active]);
				$temp .= '<ul>';
				$temp .= $this->eachSubCategory($category['sub']);
				$temp .= '</ul></li>';
			}
			$active = NULL;
		}

		return $temp;
	}
}