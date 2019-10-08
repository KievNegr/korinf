<?php

namespace app\models;

use Yii;

use yii\base\Model;

class Search extends Model
{
	public $tag;
	
	public function rules()
	{
	    return [
	        // тут определяются правила валидации
	    ];
	}
}

?>