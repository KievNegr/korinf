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
class Newcurr extends Model
{
    public $eur; //ЧПУ ccылка
    public $usd; //Title страницы
    public $date; //Описание страницы

    public function rules()
    {
    	return [
    		[['eur', 'usd', 'date'], 'required'],
    	];
    }
}
