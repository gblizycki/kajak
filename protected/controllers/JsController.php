<?php

/**
 * Description of JsController
 * Klasa JsController jest kontrolerem aplikacji odpowiedzialym za obsługą 
 * klienta aplikacji (JavaScript). Komunikacja odbywa się poprzez akcje
 * Filter - podstawowa akcja wybierająca modele
 * Data - akcja zwracająca faktyczne modele do klienta
 * View - akcja zwracająca pojedyńczy model
 * Edit - akcja pozwalająca edytować obiekty
 * @name JsController
 * @author Grzegorz Bliżycki <grzegorzblizycki@gmail.com>
 */
class JsController extends Controller
{

    /**
     * Domyślny layout używany przez akcje kontrolera
     * Wartość null ustawia brak używanego layout'u
     * @var mixed 
     */
    public $layout = null;

    /**
     * @return array action filters
     */
    public function filters()
    {
        return array(
            'rights',
        );
    }

    /**
     * Akcje nie chronione przez moduł @see Rights
     * @return string 
     */
    public function allowedActions()
    {
        return 'filter,data,view';
    }

    /**
     * Akcja filtruje modele oraz zwraca json zawierający parametry:
     * pagesize - tablice rozmiarów stron dla poszczególnych typów modeli
     * panel - kod html dla bocznego panelu
     * pages - tablica zawierająca sposób w jaki należy odpytywać akcję data
     * categories - tablica kategorii wraz ze stylami
     * scenario - scenariusz użyty podczas akcji (domyślnie list)
     */
    public function actionFilter()
    {
        $objects = array();
        $models = array();
        $filters = array();
        $pages = array();
        $categoriesExport = array();
        $filterObjects = array();
        $type = $this->setVariable('type', array());
        $size = $this->setVariable('pagesize', array('Route' => 30, 'Area' => 30, 'Place' => 50));
        //Główna pętla obsługująca wszystkie typy
        foreach ($type as $t)
        {
            //Pobranie modelu
            $obj = CMongoDocument::model($t);
            //Ustawienie atrybutów modelu służących do filtrowania
            $obj->unsetAttributes();
            if (isset($_GET[$t]))
                $obj->setAttributes($_GET[$t]);
            $dp = $obj->search(false);
            //Wybór filtrów
            $this->selectFilters($obj, $t, $filters, $categoriesExport);
            //Wprowadzenie filtrów do kryteriów wyszukiwania
            $criteria = new CMongoCriteria($dp->getCriteria());
            foreach ($filters[$t] as $filter)
            {
                $filter->setFilter($criteria, $obj);
            }
            $oldCriteria = $dp->getCriteria();
            //Ograniczenie liczby atrybutów wybieranych modeli
            $criteria->select(array('_id', 'info.name', 'info.description', 'info.format'));
            $criteria = $criteria->mergeWith($oldCriteria);
            $dp->setCriteria($criteria);
            $objects[$t] = $obj->findAll($criteria);
            $pageCount = ceil($obj->findAll($criteria)->count() / $size[$t]);
            //Określenie ilości stron danego obiektu
            for ($i = 0; $i < $pageCount; $i++)
            {
                $pages[] = array($t, $i);
            }
            $models[$t] = $objects[$t];
            $filterObjects[$t] = $obj;
        }
        $currentUrl = $_GET;
        unset($currentUrl['backUrl']);
        $currentUrl = '/js/filter?' . http_build_query($currentUrl);
        $backUrl = null;
        $panel = $this->renderPartial('panel', array('filters' => $filters, 'objects' => $objects, 'type' => $type,
            'models' => $filterObjects, 'backUrl' => $backUrl, 'currentUrl' => $currentUrl, 'realModels' => $models), true, true);
        echo CJSON::encode(array('panel' => $panel, 'pages' => $pages, 'pagesize' => $size, 'categories' => $categoriesExport, 'scenario' => 'list'));
    }

    /**
     * Akcja zwracające faktyczne modele do klienta w formie json'a zawierającego
     * tablicę obiektów (objects)
     */
    public function actionData()
    {
        //quick cacheing solution $_GET => json as key in cache
        $cacheQuickId = json_encode($_GET);
        $value = Yii::app()->cache->get($cacheQuickId);
        if ($value !== false)
        {
            echo $value;
            return;
        }
        $objects = array();
        $models = array();
        $categoriesExport = array();
        //select good object types
        $type = $this->setVariable('type', array());
        $page = $this->setVariable('page', 0);
        $size = $this->setVariable('pagesize', array('Route' => 30, 'Area' => 30, 'Place' => 50));
        foreach ($type as $t)
        {
            $obj = CMongoDocument::model($t);
            $obj->unsetAttributes();
            if (isset($_GET[$t]))
                $obj->setAttributes($_GET[$t]);
            $dp = $obj->search(false);
            $this->selectFilters($obj, $t, $filters, $categoriesExport);

            $criteria = new CMongoCriteria($dp->getCriteria());
            foreach ($filters[$t] as $filter)
            {
                $filter->setFilter($criteria, $obj);
            }
            $oldCriteria = $dp->getCriteria();
            $criteria = $criteria->mergeWith($oldCriteria);
            $criteria->setLimit($size[$t]);
            $criteria->setOffset($page * $size[$t]);
            $dp->setCriteria($criteria);

            $obj->setUseCursor(true);
            $objects[$t] = $obj->findAll($criteria);
            $cursor = $objects[$t];
            $objects[$t] = array();
            foreach ($cursor as $obji)
            {
                $objects[$t][] = $this->array_filter_recursive($obji->exportView());
            }
            Yii::app()->cache->set('export' . (string) $dp, $objects[$t], 5000);
        }
        $encoded = json_encode(array('objects' => $objects));
        echo $encoded;
    }

    /**
     * Akcja wybierająca pojedyńczy obiekt z bazy oraz wyświetlająca go na mapie oraz 
     * w panelu bocznym
     * @param string $id Id obiektu
     * @param string $type Typ obiektu (Area,Route,Place)
     */
    public function actionView($id, $type)
    {
        $objects = array();
        $model = $this->{'load' . $type}($id);
        $objects[$type][] = $model;
        $dataSource = DataExchange::module()->getDataSource($model->info->format);
        $backUrl = isset($_GET['backUrl']) ? $_GET['backUrl'] : null;
        foreach ($objects[$type] as $index => $object)
        {
            $objects[$type][$index] = $this->array_filter_recursive($object->exportView());
        }
        $exportCategories = array();
        if (is_array($model->category))
        {
            foreach ($model->category as $category)
            {
                $cat = CMongoDocument::model('Category' . $type)->findByPk($category);
                $exportCategories[$type][$cat->id] = $cat->exportView();
            }
        } elseif ($model->category !== null)
        {
            $category = CMongoDocument::model('Category' . $type)->findByPk(new MongoId($model->category));
            $exportCategories[$type] = array($category->id => $category->exportView());
        }

        //var_dump($category);die();
        echo CJSON::encode(array('objects' => $objects, 'categories' => $exportCategories, 'scenario' => 'single',
            'panel' => $dataSource->renderObject(array('model' => $model, 'backUrl' => $backUrl))));
    }

    /**
     * Akcja wybierająca pojedyńczy obiekt z bazy oraz wyświetlająca go na mapie oraz
     * w panelu bonczym w celu edycji
     * @param string $id Id obiektu
     * @param string $type Typ obiektu (Area,Route,Place)
     */
    public function actionEdit($id, $type)
    {
        $objects = array();
        $model = $this->{'load' . $type}($id);
        if (isset($_POST[$type]))
        {
            $model->setAttributes($_POST[$type]);
            try
            {
                $model->initEmbbededArray();
            } catch (Exception $e)
            {
                
            }
            if ($model->validate() && $model->save())
            {

                Yii::app()->user->setFlash('edit', $type . ' update successful');
                Yii::app()->cache->flush();
            } else
            {
                Yii::app()->user->setFlash('edit', $type . ' update failed');
                $model = $this->{'load' . $type}($id);
            }
        }
        $objects[$type][] = $model;
        $dataSource = DataExchange::module()->getDataSource($model->info->format);
        if (isset($_GET['backUrl']))
        {
            $backUrl = $_GET['backUrl'];
        } elseif (isset($_POST['backUrl']))
        {
            $backUrl = $_POST['backUrl'];
        } else
        {
            $backUrl = null;
        }

        foreach ($objects[$type] as $index => $object)
        {
            $objects[$type][$index] = $this->array_filter_recursive($object->exportView());
        }
        $exportCategories = array();
        if (is_array($model->category))
        {
            foreach ($model->category as $category)
            {
                $cat = CMongoDocument::model('Category' . $type)->findByPk($category);
                $exportCategories[$type][$cat->id] = $cat->exportView();
            }
        } elseif ($model->category !== null)
        {
            $category = CMongoDocument::model('Category' . $type)->findByPk(new MongoId($model->category));
            $exportCategories[$type] = array($category->id => $category->exportView());
        }

        //var_dump($category);die();
        echo CJSON::encode(array('objects' => $objects, 'categories' => $exportCategories, 'scenario' => 'edit',
            'panel' => $dataSource->renderObjectForm(array('model' => $model, 'currentUrl' => $backUrl, 'backUrl' => $backUrl))));
    }

    /**
     * Funckja ładuje model obszaru @see Area z bazy danych 
     * @param string $id Area id
     * @return Area
     * @throws CDbException 
     */
    protected function loadArea($id)
    {
        $model = Area::model()->findByPk(new MongoId($id));
        if ($model === null)
            throw new CDbException('Area(' . $id . ') not found');
        return $model;
    }

    /**
     * Funckja ładuje model miejsca @see Place z bazy danych 
     * @param string $id Place id
     * @return Place
     * @throws CDbException 
     */
    protected function loadPlace($id)
    {
        $model = Place::model()->findByPk(new MongoId($id));
        if ($model === null)
            throw new CDbException('Place(' . $id . ') not found');
        return $model;
    }

    /**
     * Funckja ładuje model trasy @see Route z bazy danych 
     * @param string $id Route id
     * @return Route
     * @throws CDbException 
     */
    protected function loadRoute($id)
    {
        $model = Route::model()->findByPk(new MongoId($id));
        if ($model === null)
            throw new CDbException('Route(' . $id . ') not found');
        return $model;
    }

    /**
     * Funkcja odrzuca puste wartości (null,array()) rekursywnie w całej tabeli
     * @param array $input
     * @return array 
     */
    protected function array_filter_recursive($input)
    {
        foreach ($input as &$value)
        {
            if (is_array($value))
            {
                $value = $this->array_filter_recursive($value);
            }
        }

        return array_filter($input, array($this, 'checkNull')); //'checkNull');
    }

    /**
     * Funckja wybiera odpowiednie filtry z bazy danych oraz kategorie
     * @param mixed $object
     * @param string $type
     * @param array $filters
     * @param array $categoriesExport 
     */
    protected function selectFilters($object, $type, &$filters = array(), &$categoriesExport = array())
    {
        //catogry select
        $filters[$type] = array();
        if ($object->category != null)
        {
            $categories = $object->category;
        } else
        {
            $categories = $object->getDb()->command(
                    array("distinct" => $object->getCollectionName(),
                        "key" => "category",
                        "query" => $object->search()->getCriteria()->getConditions()
                    ));
            $categories = $categories['values'];
        }

        if (is_array($categories))
        {
            foreach ($categories as $category)
            {
                $cat = CMongoDocument::model('Category' . $type)->findByPk(new MongoId($category));
                $categoriesExport[$type][$cat->id] = $this->array_filter_recursive($cat->exportView());
                if ($cat != null && count($cat->filters) > 0)
                    $filters[$type] = CMap::mergeArray($filters[$type], $cat->filters);
            }
        }
        elseif ($categories != null)
        {
            //one category, select filter from this category
            $cat = CMongoDocument::model('Category' . $type)->findByPk(new MongoId($categories));
            $categoriesExport[$t][$cat->id] = $this->array_filter_recursive($cat->exportView());
            if (count($cat->filters) > 0)
                $filters[$type] = CMap::mergeArray($filters[$type], $cat->filters);
        }
    }

    /**
     * Funkcja ustawia odpowiednią wartość zmiennej na podstawie $_GET lub domyślnej wartości ($defaultValue)
     * @param string $variableName Nazwa zmiennej w talbicy $_GET
     * @param mixed $defaultValue Domyślna wartość zasotoswana w przypadku braku zmiennej w talbicy $_GET
     * @return mixed
     */
    protected function setVariable($variableName, $defaultValue = null)
    {
        if (isset($_GET[$variableName]))
        {
            $variable = $_GET[$variableName];
        } else
        {
            $variable = $defaultValue;
        }
        return $variable;
    }

    /**
     * Funkcja sprawdzająca element tablicy do odrzucenia jeśli "pusty"
     * @param mixed $value
     * @return boolean 
     */
    protected function checkNull($value)
    {
        if (is_string($value) && strlen($value) === 0)
            return false;
        if (is_array($value))
        {
            if (count($value) == 0)
                return false;
            return true;
        }
        return $value !== null;
    }

}

