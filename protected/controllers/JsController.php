<?php

class JsController extends Controller {

    public $layout = null;

    /**
     * Declares class-based actions.
     */
    public function filters() {
        return array(
                //'rights',
        );
    }

    public function actionFilter() {
        $objects = array();
        $models = array();
        $filters = array();
        $pages = array();
        $categoriesExport = array();
        //select good object types
        if (isset($_GET['type']))
            $type = $_GET['type'];
        else
            $type = array();
        //set good scenario
        if (isset($_GET['scenario']))
            $scenario = $_GET['scenario'];
        else
            $scenario = 'view';
        if (isset($_GET['pagesize']))
            $size = $_GET['pagesize'];
        else
            $size = array('Route' => 30, 'Area' => 30, 'Place' => 50);
        $filterObjects = array();
        foreach ($type as $t) {
            //select object of $t type
            //$objects[$t] = CMongoDocument::model($t)->findAll();
            $obj = CMongoDocument::model($t);

            $obj->unsetAttributes();
            if (isset($_GET[$t]))
                $obj->setAttributes($_GET[$t]);
            Yii::beginProfile('filters');
            //get filters from selected category
            if (is_array($obj->category)) {
                //many categories, gather all possible filters ?
                //echo 'array';
            } elseif ($obj->category != null) {
                //one category, select filter from this category
                $filters[$t] = CMongoDocument::model('Category' . $t)->findByPk(new MongoId($obj->category))->filters;
            } else {
                //try to get one category from 
            }
            $dp = $obj->search(false);
            //catogry select
            $filters[$t] = array();
            if ($obj->category != null)
                $categories = $obj->category;
            else {
                $categories = $obj->getDb()->command(array("distinct" => $obj->getCollectionName(), "key" => "category", "query" => $obj->search()->getCriteria()->getConditions()));
                $categories = $categories['values'];
            }

            if (is_array($categories)) {
                //many categories, gather all possible filters ?
                foreach ($categories as $category) {
                    $cat = CMongoDocument::model('Category' . $t)->findByPk(new MongoId($category));
                    $categoriesExport[$t][$cat->id] = $this->array_filter_recursive($cat->{'export' . ucfirst($scenario)}());
                    if ($cat != null && count($cat->filters) > 0)
                        $filters[$t] = CMap::mergeArray($filters[$t], $cat->filters);
                }
            }
            elseif ($categories != null) {

                //one category, select filter from this category
                $cat = CMongoDocument::model('Category' . $t)->findByPk(new MongoId($categories));
                $categoriesExport[$t][$cat->id] = $this->array_filter_recursive($cat->{'export' . ucfirst($scenario)}());
                if (count($cat->filters) > 0)
                    $filters[$t] = CMap::mergeArray($filters[$t], $cat->filters);
            }

            $criteria = new CMongoCriteria($dp->getCriteria());
            foreach ($filters[$t] as $filter) {
                $filter->setFilter($criteria, $obj);
            }
            $oldCriteria = $dp->getCriteria();
            $criteria->select(array('_id', 'info.name', 'info.description', 'info.format'));
            $criteria = $criteria->mergeWith($oldCriteria);
            $dp->setCriteria($criteria);
            Yii::endProfile('filters');
            Yii::beginProfile('loaddata');
            //$objects[$t] = $dp->data;
            $objects[$t] = $obj->findAll($criteria);
            Yii::endProfile('loaddata');
            $pageCount = ceil($obj->findAll($criteria)->count() / $size[$t]);

            for ($i = 0; $i < $pageCount; $i++) {
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
        echo CJSON::encode(array('panel' => $panel, 'pages' => $pages, 'pagesize' => $size, 'categories' => $categoriesExport));
    }

    public function actionData() {
        //quick cacheing solution $_GET => json as key in cache
        $cacheQuickId = json_encode($_GET);
        $value = Yii::app()->cache->get($cacheQuickId);
        $value=false;
        //$value=false;
        if ($value !== false) {
            echo $value;
            return;
        }
        $objects = array();
        $models = array();
        $categoriesExport = array();
        //select good object types
        if (isset($_GET['type']))
            $type = $_GET['type'];
        else
            $type = array();

        if (isset($_GET['page']))
            $page = $_GET['page'];
        else
            $page = 0;
        if (isset($_GET['pagesize']))
            $size = $_GET['pagesize'];
        else
            $size = array('Route' => 30, 'Area' => 30, 'Place' => 50);

        foreach ($type as $t) {

            Yii::beginProfile('rest');
            $obj = CMongoDocument::model($t);

            $obj->unsetAttributes();
            if (isset($_GET[$t]))
                $obj->setAttributes($_GET[$t]);
            //get filters from selected category
            if (is_array($obj->category)) {
                //many categories, gather all possible filters ?
            } elseif ($obj->category != null) {
                //one category, select filter from this category

                $filters[$t] = CMongoDocument::model('Category' . $t)->findByPk(new MongoId($obj->category))->filters;
            } else {
                //try to get one category from 
            }
            $dp = $obj->search(false);
            //catogry select
            $filters[$t] = array();
            if ($obj->category != null)
                $categories = $obj->category;
            else {
                $categories = $obj->getDb()->command(array("distinct" => $obj->getCollectionName(), "key" => "category", "query" => $obj->search()->getCriteria()->getConditions()));
                $categories = $categories['values'];
            }

            if (is_array($categories)) {
                //many categories, gather all possible filters ?
                foreach ($categories as $category) {
                    $cat = CMongoDocument::model('Category' . $t)->findByPk(new MongoId($category));
                    if ($cat != null && count($cat->filters) > 0)
                        $filters[$t] = CMap::mergeArray($filters[$t], $cat->filters);
                }
            }
            elseif ($categories != null) {

                //one category, select filter from this category
                $cat = CMongoDocument::model('Category' . $t)->findByPk(new MongoId($categories));
                if (count($cat->filters) > 0)
                    $filters[$t] = CMap::mergeArray($filters[$t], $cat->filters);
            }


            $criteria = new CMongoCriteria($dp->getCriteria());
            foreach ($filters[$t] as $filter) {
                $filter->setFilter($criteria, $obj);
            }
            $oldCriteria = $dp->getCriteria();
            $criteria = $criteria->mergeWith($oldCriteria);
            $criteria->setLimit($size[$t]);
            $criteria->setOffset($page * $size[$t]);
            $dp->setCriteria($criteria);

            Yii::endProfile('rest');

            $obj->setUseCursor(true);
            //
            //$objects[$t]->limit($size[$t]);
            //$objects[$t]->offset($page*$size[$t]);
            //var_dump(count($objects[$t]));
            $scenario = 'view';
            //var_dump(json_encode($_GET));die();
            $dependecy = new CMongoCacheDependency(CMongoDocument::model($t),'updateDate');
            
            $value = Yii::app()->cache->get('export' . (string) $dp);
            if ($value === false) {
                //var_dump($objects[$t]->current()->id);
                Yii::beginProfile('data2');
                //$objects[$t] = $dp->data;
                $objects[$t] = $obj->findAll($criteria);
                Yii::endProfile('data2');

                /* Yii::beginProfile('data1');
                  $objects[$t] = $obj->findAll($criteria)->toArray();
                  $cursor = $objects[$t];
                  $objects[$t] = array();
                  foreach ($cursor as $obji) {
                  $objects[$t][] = $this->array_filter_recursive($obji->{'export' . ucfirst($scenario)}());
                  }
                  ///var_dump($objects[$t][0]->id);
                  Yii::endProfile('data1');


                  Yii::beginProfile('data0');
                  $objects[$t] = $obj->findAll($criteria);
                  $cursor = $objects[$t];
                  $objects[$t] = array();
                  foreach ($cursor as $obji) {
                  $objects[$t][] = $this->array_filter_recursive($obji->{'export' . ucfirst($scenario)}());
                  }
                  //$objects[$t]->next();
                  Yii::endProfile('data0'); */
                Yii::beginProfile('export');

                $cursor = $objects[$t];
                $objects[$t] = array();
                foreach ($cursor as $obji) {
                    $objects[$t][] = $this->array_filter_recursive($obji->{'export' . ucfirst($scenario)}());
                }
                Yii::app()->cache->set('export' . (string) $dp, $objects[$t], 5000);
            } else {
                $objects[$t] = $value;
            }
            Yii::endProfile('export');
        }
        Yii::beginProfile('json2');
        $encoded = json_encode(array('objects' => $objects));
        Yii::app()->cache->set($cacheQuickId, $encoded);
        echo $encoded;
        Yii::endProfile('json2');
        /* Yii::beginProfile('json');
          echo CJSON::encode(array('objects' => $objects));
          Yii::endProfile('json'); */
    }

    public function actionViewArea($id) {
        $objects = array();
        $model = $this->loadArea($id);
        $objects['Area'][] = $model;
        $dataSource = DataExchange::module()->getDataSource($model->info->format);
        $backUrl = isset($_GET['backUrl']) ? $_GET['backUrl'] : null;
        foreach ($objects['Area'] as $index => $object) {
            $objects['Area'][$index] = $this->array_filter_recursive($object->exportView());
        }
        $category = CategoryArea::model()->findByPk(new MongoId($model->category));
        //var_dump($category);die();
        echo CJSON::encode(array('objects' => $objects, 'categories' => array('Area' => array($category->id => $category->exportView())),
            'panel' => $dataSource->renderObject(array('model' => $model, 'backUrl' => $backUrl))));
    }

    public function actionViewPlace($id) {
        $objects = array();
        $model = $this->loadPlace($id);
        $objects['Place'][] = $model;
        $dataSource = DataExchange::module()->getDataSource($model->info->format);

        $backUrl = isset($_GET['backUrl']) ? $_GET['backUrl'] : null;
        foreach ($objects['Place'] as $index => $object) {
            $objects['Place'][$index] = $this->array_filter_recursive($object->exportView());
        }
        //export categories
        $exportCategories = array();
        foreach ($model->category as $category) {
            $cat = CategoryPlace::model()->findByPk($category);
            $exportCategories['Place'][$cat->id] = $cat->exportView();
        }
        echo CJSON::encode(array('objects' => $objects, 'categories' => $exportCategories,
            'panel' => $dataSource->renderObject(array('model' => $model, 'currentUrl' => 'filter?' . Yii::app()->request->queryString, 'backUrl' => $backUrl))));
    }

    public function actionViewRoute($id) {
        $objects = array();
        $model = $this->loadRoute($id);
        $objects['Route'][] = $model;
        $dataSource = DataExchange::module()->getDataSource($model->info->format);

        $backUrl = isset($_GET['backUrl']) ? $_GET['backUrl'] : null;
        foreach ($objects['Route'] as $index => $object) {
            $objects['Route'][$index] = $this->array_filter_recursive($object->exportView());
        }

        $category = CategoryRoute::model()->findByPk($model->category);
        echo CJSON::encode(array('objects' => $objects, 'categories' => array('Route' => array($category->id => $category->exportView())),
            'panel' => $dataSource->renderObject(array('model' => $model, 'currentUrl' => 'filter?' . Yii::app()->request->queryString, 'backUrl' => $backUrl))));
    }

    //@TODO
    public function actionEditRoute($id) {
        $model = $this->loadRoute($id);
        if (isset($_POST['Route'])) {
            $model->setAttributes($_POST['Route']);
            //var_dump($model->sections);
            $model->initEmbbededArray();
            //var_dump($model->sections);die();
            if ($model->validate()) {
                $model->save();
                Yii::app()->user->setFlash('edit', 'Route update successful');
                Yii::app()->cache->flush();
            } else {
                Yii::app()->user->setFlash('edit', 'Route update failed');
                $model = $this->loadRoute($id);
            }
        }
        $objects['Route'][] = $model;
        $dataSource = DataExchange::module()->getDataSource($model->info->format);
         if (isset($_GET['backUrl'])) {
            $backUrl = $_GET['backUrl'];
        } elseif (isset($_POST['backUrl'])) {
            $backUrl = $_POST['backUrl'];
        } else {
            $backUrl = null;
        }
        foreach ($objects['Route'] as $index => $object) {
            $objects['Route'][$index] = $this->array_filter_recursive($object->exportView());
        }
        $category = CategoryRoute::model()->findByPk($model->category);
        echo CJSON::encode(array('objects' => $objects, 'categories' => array('Route' => array($category->id => $category->exportView())),
            'panel' => $dataSource->renderObjectForm(array('model' => $model, 'currentUrl' => $backUrl, 'backUrl' => $backUrl))));
    }

    public function actionEditPlace($id) {
        $model = $this->loadPlace($id);
        if (isset($_POST['Place'])) {
            $model->setAttributes($_POST['Place']);
            if ($model->validate() && $model->save()) {

                Yii::app()->user->setFlash('edit', 'Place update successful');
                Yii::app()->cache->flush();
            } else {
                Yii::app()->user->setFlash('edit', 'Place update failed');
                $model = $this->loadPlace($id);
            }
        }
        $objects['Place'][] = $model;
        $dataSource = DataExchange::module()->getDataSource($model->info->format);
        if (isset($_GET['backUrl'])) {
            $backUrl = $_GET['backUrl'];
        } elseif (isset($_POST['backUrl'])) {
            $backUrl = $_POST['backUrl'];
        } else {
            $backUrl = null;
        }
        foreach ($objects['Place'] as $index => $object) {
            $objects['Place'][$index] = $this->array_filter_recursive($object->exportView());
        }
        $exportCategories = array();
        foreach ($model->category as $category) {
            $cat = CategoryPlace::model()->findByPk($category);
            $exportCategories['Place'][$cat->id] = $cat->exportView();
        }
        echo CJSON::encode(array('objects' => $objects, 'categories' => $exportCategories,
            'panel' => $dataSource->renderObjectForm(array('model' => $model, 'currentUrl' => $backUrl, 'backUrl' => $backUrl))));
    }

    //@TODO
    public function actionEditArea($id) {
        $model = $this->loadArea($id);
        if (isset($_POST['Area'])) {
            $model->setAttributes($_POST['Area']);
            $model->initEmbbededArray();
            if ($model->validate() && $model->save()) {

                Yii::app()->user->setFlash('edit', 'Area update successful');
                Yii::app()->cache->flush();
            } else {
                Yii::app()->user->setFlash('edit', 'Area update failed');
                $model = $this->loadArea($id);
            }
        }
        $objects['Area'][] = $model;
        $dataSource = DataExchange::module()->getDataSource($model->info->format);
        if (isset($_GET['backUrl'])) {
            $backUrl = $_GET['backUrl'];
        } elseif (isset($_POST['backUrl'])) {
            $backUrl = $_POST['backUrl'];
        } else {
            $backUrl = null;
        }
        foreach ($objects['Area'] as $index => $object) {
            $objects['Area'][$index] = $this->array_filter_recursive($object->exportView());
        }
        $category = CategoryArea::model()->findByPk(new MongoId($model->category));
        echo CJSON::encode(array('objects' => $objects, 'categories' => array('Area' => array($category->id => $category->exportView())),
            'panel' => $dataSource->renderObjectForm(array('model' => $model, 'currentUrl' => $backUrl, 'backUrl' => $backUrl))));
    }

    protected function loadArea($id) {
        $model = Area::model()->findByPk(new MongoId($id));
        if ($model === null)
            throw new CDbException('Area(' . $id . ') not found');
        return $model;
    }

    protected function loadPlace($id) {
        $model = Place::model()->findByPk(new MongoId($id));
        if ($model === null)
            throw new CDbException('Place(' . $id . ') not found');
        return $model;
    }

    protected function loadRoute($id) {
        $model = Route::model()->findByPk(new MongoId($id));
        if ($model === null)
            throw new CDbException('Route(' . $id . ') not found');
        return $model;
    }

    protected function array_filter_recursive($input) {
        foreach ($input as &$value) {
            if (is_array($value)) {
                $value = $this->array_filter_recursive($value);
            }
        }

        return array_filter($input, 'checkNull');
    }

    }

function checkNull($value) {
    if (is_array($value)) {
        if (count($value) == 0)
            return false;
        return true;
    }
    return $value !== null;
}