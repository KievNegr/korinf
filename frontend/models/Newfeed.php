<?php

namespace app\models;

use Yii;
use yii\base\Model;

/**
 * LoginForm is the model behind the login form.
 *
 * @property User|null $user This property is read-only.
 *
 */
class Newfeed extends Model
{
    public $name; //Title страницы
    public $phone; //Описание страницы
    public $question; //Ключевые слова страницы

    public function rules()
    {
    	return [
    		[['name', 'phone', 'question'], 'required'],
    	];
    }
}
