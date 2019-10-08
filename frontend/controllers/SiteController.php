<?php
namespace frontend\controllers;

use Yii;
use yii\base\InvalidParamException;
use yii\web\BadRequestHttpException;
use yii\web\Controller;
use frontend\models\SignupForm;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use yii\helpers\Html;
use app\models\StaticPage;
use app\models\StaticCategory;
use app\models\ItemCategory;
use app\models\Item;
use app\models\Partners;
use app\models\Images;
use app\models\Search;
use app\models\Tags;
use app\models\TagLinked;
use app\models\Currency;
use app\models\Newcurr;

/**
 * Site controller
 */
class SiteController extends Controller
{
    public $menu;
    public $noindex;
    public $image;
    public $url;
    public $itemName;
    public $itemPrice;
    public $itemBrand;

    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['logout', 'signup'],
                'rules' => [
                    [
                        'actions' => ['signup'],
                        'allow' => true,
                        'roles' => ['?'],
                    ],
                    [
                        'actions' => ['logout'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }

    /**
     * @inheritdoc
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }

    //Display Error
    public function actionErrorpage()
    {
    	$allCategories = ItemCategory::find()->where(['sub_id' => NULL])->orderBy('order')->all(); //Вытаскиваем все родительские категории

        
        foreach($allCategories as $val){
            $sub = $this->getSubCategory($val->id);

            $listCategories[] = Array(
                'name' => $val->name,
                'sef' => $val->sef,
                'sub' => $sub
            );
        }

        $this->menu = $allCategories;

        return $this->render('error', [
            'categories' => $listCategories
        ]);
    }

    public function getSubCategory($id)
    {
        return ItemCategory::find()->where(['sub_id' => $id])->all();
    }

    /**
     * Displays homepage.
     *
     * @return mixed
     */
    public function actionIndex()
    {
        $allCategories = ItemCategory::find()->where(['sub_id' => NULL])->orderBy('order')->all(); //Вытаскиваем все родительские категории

        $this->menu = $allCategories;

        $tags = Tags::find()->all();

        $currency = Currency::find()->all();

        foreach($currency as $cur)
        {
            Yii::$app->view->params['eur'] = $cur->eur;
            Yii::$app->view->params['usd'] = $cur->usd;
            Yii::$app->view->params['date'] = substr($cur->date, 8, 2) . '.' . substr($cur->date, 5, 2) . '.' . substr($cur->date, 0, 4);
        }

        $listTags = Array();

        foreach($tags as $tag)
        {
            $listTags[] = '"' . $tag->tag_name . '"';
        }

        $tags = implode(',', $listTags);

        return $this->render('index', [
            'tags' => $tags,
            'categories' => $allCategories
        ]);
    }

    public function actionSignup()
    {
        $model = new SignupForm();
        if ($model->load(Yii::$app->request->post())) {
            if ($user = $model->signup()) {
                if (Yii::$app->getUser()->login($user)) {
                    return $this->goHome();
                }
            }
        }

        return $this->render('signup', [
            'model' => $model,
        ]);
    }

    public function actionEquipment($sef = 'index')
    {                
        /*-----------------Начинаем построение списка категорий-----------------------*/
        if(!empty($_SERVER['QUERY_STRING']))
        {
        	//print_r($_SERVER);
        	$url = $_SERVER['HTTP_X_FORWARDED_PROTO'] . "://" . $_SERVER['SERVER_NAME'] . "/equipment/" . $sef . ".html";
        	header("Location: $url");
			//echo $url;
			exit;
        }

        $sef = Html::encode($sef); //Получаем sef ссылку
        $items = NULL;
        $text = NULL;
        $tags = NULL;

        $currency = Currency::find()->all();

        foreach($currency as $cur)
        {
            Yii::$app->view->params['eur'] = $cur->eur;
            Yii::$app->view->params['usd'] = $cur->usd;
            Yii::$app->view->params['date'] = substr($cur->date, 8, 2) . '.' . substr($cur->date, 5, 2) . '.' . substr($cur->date, 0, 4);
        }

        if($sef != 'index') //Если страница не главная то панеслась
        {
            $this->menu = ItemCategory::find()->where(['sub_id' => NULL])->orderBy('order')->all(); //Вытаскиваем все родительские категории

            $selectCategory = ItemCategory::find()->where(['sef' => $sef])->one(); //Вытаскиваем данные выбраной категории

            if(empty($selectCategory)) throw new \yii\web\NotFoundHttpException; // Если позиции нету то вызываем 404

            $subId = $selectCategory->sub_id; //Получили его subId

            if(!empty($selectCategory->partners))
            {
                $dbPartners = Partners::find()->where('id IN(' . $selectCategory->partners . ')')->all(); //Ищем название брендов

                foreach($dbPartners as $valPartners)
                {
                    $descrPartners .= $valPartners->name . ", ";
                }

                $descrPartners = substr($descrPartners, 0, - 2);

                $description = $selectCategory->description . ". Для пекарен любого типа. Супермаркетов, пиццерий ✓ Выгодные ЦЕНЫ ✓ Гарантия и сервис ✓ доставка по Киеву и Украине. " . $descrPartners . " ☎ +38(044)502-44-16";
            }
            else
            {
                $description = $selectCategory->description . ". Для пекарен любого типа. Супермаркетов, пиццерий ✓ Выгодные ЦЕНЫ ✓ Гарантия и сервис ✓ доставка по Киеву и Украине. ☎ +38(044)502-44-16";
            }


            $title = $selectCategory->title . " в Киеве и Украине | Коринф";
            
            $keywords = $selectCategory->keywords;
            $h1 = $selectCategory->name;
            $text = $selectCategory->text;

            $subSelectItem = ItemCategory::find()->where(['sub_id' => $selectCategory->id])->all(); //Ищем субкатегории выбраной категории
            
            if(!empty($subSelectItem)) //Если субкатегории существуют
            {
                foreach($subSelectItem as $subItem) //Перечисляем все и заносим в массив
                {
                    $tempSub[] = ['name' => $subItem->name, 'sef' => $subItem->sef, 'id' => $subItem->id, 'active' => false, 'sub' => NULL]; //То добавляем их в массив
                }
            }
            else // Если субкатегорий нету то ничего не заносим
            {
                $tempSub = NULL;
            }

            $child[] = ['name' => $selectCategory->name, 'sef' => $selectCategory->sef, 'id' => $selectCategory->id, 'active' => true, 'sub' => $tempSub]; //Выбранную категорию сразу добавили в массив вместе с ее субкатегориями

            $partners = ItemCategory::find()->where(['sub_id' => $selectCategory->sub_id])->all(); //Ищем сверстников выбраной категории, у которых такой же sub_id

            if(count($partners) > 1) //Если подобные найдены то работаем (больше 1го потому что одна такая категория точно есть - наша выбранная)
            {
                foreach($partners as $tempPartners)
                {
                    if($tempPartners->id != $selectCategory->id) //Сравниваем выбраную категорию с найдеными
                    {
                        $child[] = ['name' => $tempPartners->name, 'sef' => $tempPartners->sef, 'id' => $tempPartners->id, 'active' => false, 'sub' => NULL];// Если найдены то добавляем в массив
                    }
                }
            }

            $searchParent = TRUE;

            while($searchParent == TRUE) //Теперь ищем родителя
            {
                $getParent = ItemCategory::find()->where(['id' => $subId])->one(); //Ищем родительскую категорию

                if(count($getParent) > 0) //Если родитель существует
                {
                    $breadcrumbs [] = [
                        'homeLink' => ['label' => 'Главная', 'url' => '/'],
                        //'template' => '<li>{link}</li>', //  шаблон для этой ссылки  
                        'label' => $getParent->name,
                        'url' => ['equipment/' . $getParent->sef],
                        'itemprop' => 'item'
                    ];

                    $tempParentSub = Array(); //Обьявляем массив в который будут вносится подобные категории как и найденого родителя

                    $parentParners = ItemCategory::find()->where(['sub_id' => $getParent->sub_id])->all(); //Ищем подобные категории одного уровня найденого родителя
                    if(count($parentParners) > 0) //Если подобные найдены то работаем
                    {
                        foreach($parentParners as $tempPartners)//Начинаем перечислять подобные
                        {
                            if($tempPartners->id == $getParent->id)
                            {
                                $tempParentSub[] = ['name' => $tempPartners->name, 'sef' => $tempPartners->sef, 'id' => $tempPartners->id, 'active' => true, 'sub' => $child]; //Если совпал найденый ID с найденым родительским то вносим ее в массив с ее субкатегориями (переменная $child)
                            }
                            else
                            {
                                $tempParentSub[] = ['name' => $tempPartners->name, 'sef' => $tempPartners->sef, 'id' => $tempPartners->id, 'active' => false, 'sub' => NULL]; //Если ID не совпали то просто вносим как подобные
                            }
                        }
                        
                    }
                    $child = $tempParentSub; //Присваиваем новый массив $child
                
                    $subId = $getParent->sub_id; //Получаем subId родителя и ищем далее
                }
                else
                {
                    $searchParent = FALSE; //Иначе выходим с цикла
                }

                $cat = $child; //Если родителя нашли то заносим его в массив
            }

            

            $i = 1;
            foreach($cat as $ac)
            {
                if($ac['active'] == 1)
                {
                    $allCategories[0] = $ac;
                }
                else
                {
                    $allCategories[$i] = $ac;
                }
                $i++;
            }
            ksort($allCategories);

            $breadcrumbs [] = [
                'template' => '<li>{link}</li>', //  шаблон для этой ссылки  
                'label' => 'Оборудование',
                'url' => ['site/equipment']
            ];

            $breadcrumbs = array_reverse($breadcrumbs);

            $breadcrumbs [] = [
                'template' => '<li class="active">{link}</li>', //  шаблон для этой ссылки  
                'label' => $selectCategory->name,
                'url' => ['equipment/' . $selectCategory->sef]
            ];

            /*------------Начинаем показ Оборудования нашей выбраной категории включая субкатегории----------*/

            $getChild = ItemCategory::find()->where(['sub_id' => $selectCategory->id])->all();

            if(count($getChild) > 0)
            {
                $idS = $this->getAllItem($getChild);
                $idS[] = $selectCategory->id;

                $arr = array();
                foreach($idS as $id)
                {
                    if(!is_array($id))
                    {
                        $arr[] = $id;
                    }
                    else
                    {
                        
                        $tempArr = $this->toLine($id);
                        $arr = array_merge($arr, $tempArr);
                    }
                }

                $idS = implode(',', $arr);
                
                $getItem = Item::find()->where('Category IN(' . $idS . ')')->orderBy('order_list ASC')->all();
            }
            else
            {
                $getItem = Item::find()->where(['category' => $selectCategory->id])->orderBy('order_list ASC')->all();
            }

            $items = $getItem;

            $tagsId = TagLinked::find()->where(['id_category' => $selectCategory->id])->all();
            
            if(count($tagsId) > 0)
            {
                $listTagsId = Array();

                foreach($tagsId as $tags)
                {
                    $listTagsId[] = $tags->id_tag;
                }

                $listTagsId = implode(',', $listTagsId);

                $tags = Tags::find()->where('id IN(' . $listTagsId . ')')->all();
            }

            /*------------End of list equipment------------*/
        }
        else
        {
            $title = 'Оборудование для пищевой промышленности | Коринф';
            $description = 'Оборудование для пищевой промышленности. Доставка по Киеву, Украине. Гарантия, сервис. ☎ +38(044)502-44-16';
            $keywords = 'Европейское оборудование для пищевой промышленности';
            $h1 = 'Оборудование';

            $allCategories = ItemCategory::find()->where(['sub_id' => NULL])->orderBy('order')->all(); //Вытаскиваем все родительские категории
            $selectCategory = NULL;
            $this->menu = $allCategories;
            
            $breadcrumbs [] = [
                'template' => '<li class="active">{link}</li>', //  шаблон для этой ссылки  
                'label' => 'Оборудование'
            ];
        }
        
        /*------------End of List Category-------------------*/

        return $this->render('equipment', [
            'categories' => $allCategories,
            'selectCategory' => $selectCategory,
            'breadcrumbs' => $breadcrumbs,
            'sef' => $sef,
            'items' => $items,
            'title' => $title,
            'description' => $description,
            'keywords' => $keywords,
            'h1' => $h1,
            'text' => $text,
            'tags' => $tags
        ]);
    }

    private function getAllItem($categories)
    {
        //$idS = Array();

        foreach($categories as $category)
        { 
            $idS[] = $category->id;

            $getChild = ItemCategory::find()->where(['sub_id' => $category->id])->all();
            
            if(count($getChild) > 0)
            {
                $idS[] = $this->getAllItem($getChild);
            }
        }

        
        //print_r($idS);
        return($idS);
    }

    private function toLine($idS)
    {
        foreach($idS as $id)
        {
            if(!is_array($id))
            {
                $arr[] = $id;
            }
            else
            {
                $arr = array_merge($arr, $this->toLine($id));
            }
        }
        return($arr);
    }

    public function actionStat($sef)
    {
    	$sef = Html::encode($sef);

        $this->menu = ItemCategory::find()->where(['sub_id' => NULL])->orderBy('order')->all(); //Вытаскиваем все родительские категории

        $item = Item::find()->where(['sef' => $sef])->one(); //Лезем в базу ищем позицию

        if(empty($item)) throw new \yii\web\NotFoundHttpException; // Если позиции нету то вызываем 404

        $similar = Item::find()->where(['category' => $item->category])->all(); //Лезем в базу ищем позицию

        /*----------Inserted code-----------------*/

        $selectCategory = ItemCategory::find()->where(['id' => $item->category])->one(); //Вытаскиваем данные выбраной категории

        $subId = $selectCategory->sub_id; //Получили его subId

        $subSelectItem = ItemCategory::find()->where(['sub_id' => $selectCategory->id])->all(); //Ищем субкатегории выбраной категории
        
        if(!empty($subSelectItem)) //Если субкатегории существуют
        {
            foreach($subSelectItem as $subItem) //Перечисляем все и заносим в массив
            {
                $tempSub[] = ['name' => $subItem->name, 'sef' => $subItem->sef, 'id' => $subItem->id, 'active' => false, 'sub' => NULL]; //То добавляем их в массив
            }
        }
        else // Если субкатегорий нету то ничего не заносим
        {
            $tempSub = NULL;
        }

        $child[] = ['name' => $selectCategory->name, 'sef' => $selectCategory->sef, 'id' => $selectCategory->id, 'active' => true, 'sub' => $tempSub]; //Выбранную категорию сразу добавили в массив вместе с ее субкатегориями

            $partners = ItemCategory::find()->where(['sub_id' => $selectCategory->sub_id])->all(); //Ищем сверстников выбраной категории, у которых такой же sub_id

            if(count($partners) > 1) //Если подобные найдены то работаем (больше 1го потому что одна такая категория точно есть - наша выбранная)
            {
                foreach($partners as $tempPartners)
                {
                    if($tempPartners->id != $selectCategory->id) //Сравниваем выбраную категорию с найдеными
                    {
                        $child[] = ['name' => $tempPartners->name, 'sef' => $tempPartners->sef, 'id' => $tempPartners->id, 'active' => false, 'sub' => NULL];// Если найдены то добавляем в массив
                    }
                }
            }

        $searchParent = TRUE;

        while($searchParent == TRUE) //Теперь ищем родителя
        {
            $getParent = ItemCategory::find()->where(['id' => $subId])->one(); //Ищем родительскую категорию

            if(count($getParent) > 0) //Если родитель существует
            {
                $tempParentSub = Array(); //Обьявляем массив в который будут вносится подобные категории как и найденого родителя

                $parentParners = ItemCategory::find()->where(['sub_id' => $getParent->sub_id])->all(); //Ищем подобные категории одного уровня найденого родителя
                
                if(count($parentParners) > 0) //Если подобные найдены то работаем
                {
                    foreach($parentParners as $tempPartners)//Начинаем перечислять подобные
                    {
                        if($tempPartners->id == $getParent->id)
                        {
                            $tempParentSub[] = ['name' => $tempPartners->name, 'sef' => $tempPartners->sef, 'id' => $tempPartners->id, 'active' => true, 'sub' => $child]; //Если совпал найденый ID с найденым родительским то вносим ее в массив с ее субкатегориями (переменная $child)
                        }
                        else
                        {
                            $tempParentSub[] = ['name' => $tempPartners->name, 'sef' => $tempPartners->sef, 'id' => $tempPartners->id, 'active' => false, 'sub' => NULL]; //Если ID не совпали то просто вносим как подобные
                        }
                    }
                    
                }
                $child = $tempParentSub; //Присваиваем новый массив $child
            
                $subId = $getParent->sub_id; //Получаем subId родителя и ищем далее
            }
            else
            {
                $searchParent = FALSE; //Иначе выходим с цикла
            }

            $cat = $child; //Если родителя нашли то заносим его в массив
        }

        $i = 1;
        foreach($cat as $ac)
        {
            if($ac['active'] == 1)
            {
                $allCategories[0] = $ac;
            }
            else
            {
                $allCategories[$i] = $ac;
            }
            $i++;
        }
        ksort($allCategories);

        /*----------End of inserted code----------*/

        $tags = Array();

        $currency = Currency::find()->all();

        foreach($currency as $cur)
        {
            Yii::$app->view->params['eur'] = $cur->eur;
            Yii::$app->view->params['usd'] = $cur->usd;
            Yii::$app->view->params['date'] = substr($cur->date, 8, 2) . '.' . substr($cur->date, 5, 2) . '.' . substr($cur->date, 0, 4);
        }

        if(!is_null($item))
        {
            $equipment = [
                'label' => 'Оборудование',
                'url' => ['equipment']
            ];

            $gallery = Images::find()->where(['id_item' => $item->id])->all();

            $parent = $item->category;

            $searchListCategory = TRUE;

            while($searchListCategory == TRUE)
            {
                $getParent = ItemCategory::find()->where(['id' => $parent])->one();
                if(!is_null($getParent->sub_id))
                {
                    $parent = $getParent->sub_id;
                }
                else
                {
                    $searchListCategory = FALSE;
                }

                $breadcrumbs[] = [
                    'label' => $getParent->name,
                    'url' => ['equipment/' . $getParent->sef]
                ];
            }

            $tagsId = TagLinked::find()->where(['id_item' => $item->id])->all();
            
            if(count($tagsId) > 0)
            {
                $listTagsId = Array();

                foreach($tagsId as $tags)
                {
                    $listTagsId[] = $tags->id_tag;
                }

                $listTagsId = implode(',', $listTagsId);

                $tags = Tags::find()->where('id IN(' . $listTagsId . ')')->all();
            }

            $breadcrumbs = array_reverse($breadcrumbs);

            array_unshift($breadcrumbs, $equipment);

            $breadcrumbs[] = [
                'template' => '<li class="active">{link}</li>', //  шаблон для этой ссылки  
                'label' => $item->name,
                'url' => ['stat/' . $item->sef]
            ];

            $brand = Partners::find()->where(['id' => $item->brand])->one();
            if(!empty($brand))
            {
                $item->brand = $brand->name;
            }
            else
            {
                $item->brand = 'Unnamed';
            }


            $this->image = 'https://' . $_SERVER['SERVER_NAME'] . $item->img;

            $this->itemName = $item->name;
            $this->itemPrice = $item->price * $currency[0]['eur'];
            $this->itemBrand = $item->brand;
            return $this->render('item', [
                'item' => $item,
                'gallery' => $gallery,
                'breadcrumbs' => $breadcrumbs,
                'tags' => $tags,
                'similar' => $similar,
                'categories' => $allCategories
            ]);
        }
        else
        {
            Yii::$app->response->statusCode = 200;

            //$this->render('error', ['exception' => $exception]);
        }
    }

    public function actionContacts()
    {
        $this->menu = ItemCategory::find()->where(['sub_id' => NULL])->orderBy('order')->all(); //Вытаскиваем все родительские категории
        $page = StaticPage::find()->where(['sef' => 'contacts'])->one();
        $categories[] = [
            'template' => '<li class="active">{link}</li>', 
            'label' => $page->title,
            'url' => [$page->sef]
        ];

        $currency = Currency::find()->all();

        foreach($currency as $cur)
        {
            Yii::$app->view->params['eur'] = $cur->eur;
            Yii::$app->view->params['usd'] = $cur->usd;
            Yii::$app->view->params['date'] = substr($cur->date, 8, 2) . '.' . substr($cur->date, 5, 2) . '.' . substr($cur->date, 0, 4);
        }

        return $this->render('static', [
            'page' => $page,
            'categories' => $categories
        ]);
    }

    public function actionVacancies()
    {
        $this->menu = ItemCategory::find()->where(['sub_id' => NULL])->orderBy('order')->all(); //Вытаскиваем все родительские категории

        $page = StaticPage::find()->where(['sef' => 'vacancies'])->one();
        $categories[] = [
            'template' => '<li class="active">{link}</li>', 
            'label' => $page->title,
            'url' => [$page->sef]
        ];

        $currency = Currency::find()->all();

        foreach($currency as $cur)
        {
            Yii::$app->view->params['eur'] = $cur->eur;
            Yii::$app->view->params['usd'] = $cur->usd;
            Yii::$app->view->params['date'] = substr($cur->date, 8, 2) . '.' . substr($cur->date, 5, 2) . '.' . substr($cur->date, 0, 4);
        }

        return $this->render('static', [
            'page' => $page,
            'categories' => $categories
        ]);
    }

    public function actionPage($sef)
    {
        $this->menu = ItemCategory::find()->where(['sub_id' => NULL])->orderBy('order')->all(); //Вытаскиваем все родительские категории

        $sef = Html::encode($sef);
        
        $page = StaticPage::find()->where(['sef' => $sef])->one();
        $categories[] = [
            'template' => '<li class="active">{link}</li>', 
            'label' => $page->title,
            'url' => [$page->sef]
        ];

        if($page->category != NULL){
            $category = StaticCategory::find()->where(['id' => $page->category])->one();
            $categories[] = ['label' => $category['name'], 'url' => ['site/events']];
        }

        $categories = array_reverse($categories);

        $currency = Currency::find()->all();

        foreach($currency as $cur)
        {
            Yii::$app->view->params['eur'] = $cur->eur;
            Yii::$app->view->params['usd'] = $cur->usd;
            Yii::$app->view->params['date'] = substr($cur->date, 8, 2) . '.' . substr($cur->date, 5, 2) . '.' . substr($cur->date, 0, 4);
        }

        return $this->render('static', [
            'page' => $page,
            'categories' => $categories
        ]);
    }

    public function actionEvents()
    {
        $this->menu = ItemCategory::find()->where(['sub_id' => NULL])->orderBy('order')->all(); //Вытаскиваем все родительские категории

        $pages = StaticPage::find()->where(['not', ['category' => null]])->all();

        $currency = Currency::find()->all();

        foreach($currency as $cur)
        {
            Yii::$app->view->params['eur'] = $cur->eur;
            Yii::$app->view->params['usd'] = $cur->usd;
            Yii::$app->view->params['date'] = substr($cur->date, 8, 2) . '.' . substr($cur->date, 5, 2) . '.' . substr($cur->date, 0, 4);
        }
        
        return $this->render('events', [
            'pages' => $pages
        ]);
    }

    public function actionSearch() 
    {
        $this->menu = ItemCategory::find()->where(['sub_id' => NULL])->orderBy('order')->all(); //Вытаскиваем все родительские категории

        $this->noindex = true;

        $form = new Search(); //Не забыть валидацию

        $tag = urldecode(Html::encode(Yii::$app->request->get('tag')));
        
        if(empty($tag))
            $tag = Html::encode(Yii::$app->request->post('tag'));
        

        $currency = Currency::find()->all();

        foreach($currency as $cur)
        {
            Yii::$app->view->params['eur'] = $cur->eur;
            Yii::$app->view->params['usd'] = $cur->usd;
            Yii::$app->view->params['date'] = substr($cur->date, 8, 2) . '.' . substr($cur->date, 5, 2) . '.' . substr($cur->date, 0, 4);
        }

        $breadcrumbs[] = [
            'template' => '<li class="active">{link}</li>', //  шаблон для этой ссылки  
            'label' => 'Поиск: ' . $tag
        ];
            
        $res = Tags::find()->where('tag_name LIKE \'%' . $tag . '%\'')->one();

        if(count($res) > 0)
        {
            $linked = TagLinked::find()->where(['id_tag' => $res->id])->all();

            $inCategory = Array();
            $inItems = Array();

            $resCategory = Array();
            $resItems = Array();

            if(count($linked) > 0)
            {
                foreach($linked as $lCat)
                {
                    if(!is_null($lCat->id_category))
                    {
                        $inCategory[] = $lCat->id_category;
                    }
                    if(!is_null($lCat->id_item))
                    {
                        $inItems[] = $lCat->id_item;
                    }
                }

                if(count($inCategory) > 0)
                {
                    $inCategory = implode(',', $inCategory);
                    $resCategory = ItemCategory::find()->where('id IN(' . $inCategory . ')')->all();
                }

                if(count($inItems) > 0)
                {
                    $inItems = implode(',', $inItems);
                    $resItems = Item::find()->where('id IN(' . $inItems . ')')->all();
                }
            }

            return $this->render('search', [
                'title' => 'Результаты поиска для "' . $tag . '"',
                'description' => 'Результаты поиска для "' . $tag . '"',
                'keywords' => 'Результаты поиска для "' . $tag . '"',
                'search' => $res,
                'breadcrumbs' => $breadcrumbs,
                'categories' => $resCategory,
                'items' => $resItems
            ]);
        }
        else
        {
            return $this->render('searchempty', [
                'title' => 'Результаты поиска для "' . $tag . '"',
                'description' => 'Результаты поиска для "' . $tag . '"',
                'keywords' => 'Результаты поиска для "' . $tag . '"',
                'search' => $tag,
                'breadcrumbs' => $breadcrumbs
            ]);
        }

    }

    public function actionCurr()
    {
        
        $this->menu = ItemCategory::find()->where(['sub_id' => NULL])->orderBy('order')->all(); //Вытаскиваем все родительские категории
        
        $currency = Currency::find()->where(['id' => 1])->one();

        Yii::$app->view->params['eur'] = $currency->eur;
        Yii::$app->view->params['usd'] = $currency->usd;
        Yii::$app->view->params['date'] = substr($currency->date, 8, 2) . '.' . substr($currency->date, 5, 2) . '.' . substr($currency->date, 0, 4);
        
        if($_SERVER['REMOTE_ADDR'] == '31.128.72.110')
        {
            $form = new Newcurr();

            if($form->load(Yii::$app->request->post()) && $form->validate()) {

                $update = Currency::findOne(1);
                $update->eur = $form->eur;
                $update->usd = $form->usd;
                $update->date = $form->date;
                $update->save();

                $currency = Currency::find()->where(['id' => 1])->one();
            }

            return $this->render('currency', [
                'curr' => $currency,
                'form' => $form
            ]);
        }
        else
        {
            return $this->render('currency_err', [
                //'pages' => $pages
            ]);
        }
    }
}