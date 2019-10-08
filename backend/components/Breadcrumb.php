<?php 

namespace app\components;

use Yii;

use yii\base\Widget;
use yii\helpers\Html;

class Search extends Widget 
{
	public function run()
	{
		return $this->render('search');
	}
}