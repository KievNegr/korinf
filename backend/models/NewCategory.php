<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\imagine\Image;
use Imagine\Image\Box;
use Imagine\Image\Point;
use Imagine\Image\ImageInterface;
use app\models\Tags;
use app\models\TagLinked;

/**
 * LoginForm is the model behind the login form.
 *
 * @property User|null $user This property is read-only.
 *
 */
class NewCategory extends Model
{
    public $sef; //ЧПУ ccылка
    public $title; //Title
    public $description; //Описание
    public $keywords; //Ключевые слова
    public $name; //Имя (Н1)
    public $category; //Родительская категория (Н1)
    public $short_text; //Короткое описание
    public $full_text; //Текст
    public $tags; //Теги
    public $img; //Основная картинка страницы

    public function rules()
    {
    	return [
    		[['sef', 'title', 'description', 'keywords', 'name', 'short_text', 'category', 'full_text', 'tags'], 'required'],
    		[['img'], 'image', 'extensions' => 'jpg, png'],
    	];
    }

    public function saveImg($nameImg, $img)
    {
        $photo = Image::getImagine()->open('../../frontend/web/images/menu/' . $nameImg . '.' . $img->extension)->thumbnail(new box(491, 276))->save('../../frontend/web/images/menu/' . $nameImg . '.' . $img->extension); //Открываем нашу сохраненную картинку, изменяем размер и сохраняем

        $size = $photo->getSize(); //Получаем ее размеры
        echo $size;

        $ratio = $size->getWidth()/$size->getHeight();
        echo $ratio;

        if(round($ratio) < 1.77) //Если соотношение сторон меньше чем надо то 
        {
            $x = 245 - $size->getWidth() / 2;
            Image::watermark('images/template_menu.jpg', '../../frontend/web/images/menu/' . $nameImg . '.' . $img->extension, [$x, 0])->save('../../frontend/web/images/menu/' . $nameImg . '.' . $img->extension);
        }
        else
        {
            $y = 138 - $size->getHeight() / 2;
            Image::watermark('images/template_menu.jpg', '../../frontend/web/images/menu/' . $nameImg . '.' . $img->extension, [0, $y])->save('../../frontend/web/images/menu/' . $nameImg . '.' . $img->extension);
        } 
    }

        public function newTag($name, $idItem)
    {
        $tag = new Tags();
        $linked = new TagLinked();

        $tag->tag_name = $name;

        if($tag->save())
        {
            $idTag = $tag->id; // ID созданого тега
        }

        $linked->id_tag = $idTag;
        $linked->id_category = $idItem;

        $linked->save();
    }

    public function newTagLinked($key, $idItem)
    {
        $linked = new TagLinked();

        $linked->id_tag = $key;
        $linked->id_category = $idItem;

        $linked->save();
    }
}
