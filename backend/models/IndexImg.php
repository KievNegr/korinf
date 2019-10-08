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
class Indeximg extends Model
{
    public $imageind;

    public function rules()
    {
    	return [
    		[['imageind'], 'file', 'extensions' => 'jpg, png']
    	];
    }
}
