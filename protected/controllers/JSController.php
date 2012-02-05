<?php

class JSController extends Controller {

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
        $filterObjects = array();
        foreach ($type as $t) {
            //select object of $t type
            //$objects[$t] = CMongoDocument::model($t)->findAll();
            $obj = CMongoDocument::model($t);

            $obj->unsetAttributes();
            if (isset($_GET[$t]))
                $obj->setAttributes($_GET[$t]);
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
            $dp->setCriteria($criteria);
            
            
            $objects[$t] = $dp->data;
            /*$value = Yii::app()->cache->get(serialize($dp->criteria));
            if($value===false)
            {*/
                foreach ($objects[$t] as $index => $object) {
                    
                    $objects[$t][$index] = $this->array_filter_recursive($object->{'export' . ucfirst($scenario)}());
                    
                }
                /*$value = $objects[$t];
                Yii::app()->cache->set(serialize($dp->criteria), $value);
            }
            $objects[$t]= $value;*/
            $filterObjects[$t] = $obj;
            /*$cacheId = $t . serialize($dp->criteria) . serialize($dp->getPagination()) . serialize($dp->getSort());
            $value = Yii::app()->cache->get($cacheId);
            if ($value === false) {*/
                $value = $dp->data;
                /*Yii::app()->cache->set($cacheId, $value, 5000);
            }*/

            $models[$t] = $value; //$dp->data;
        }
        $backUrl = isset($_GET['backUrl']) ? $_GET['backUrl'] : null;
        
        /*Yii::beginProfile('render');
        $panel = Yii::app()->cache->get(Yii::app()->request->queryString);
            if($panel===false)
            {*/
                $panel = $this->renderPartial('panel', array('filters' => $filters, 'objects' => $objects, 'type' => $type,
                'models' => $filterObjects, 'currentUrl' => 'filter?' . Yii::app()->request->queryString, 'backUrl' => $backUrl, 'realModels' => $models), true, true);
          /*      Yii::app()->cache->set(Yii::app()->request->queryString,$panel);
            }*/
        echo CJSON::encode(array('objects' => $objects,
            'panel' => $panel));
        Yii::endProfile('render');
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
        echo CJSON::encode(array('objects' => $objects,
            'panel' => $dataSource->renderObject(array('model' => $model, 'currentUrl' => 'filter?' . Yii::app()->request->queryString, 'backUrl' => $backUrl))));
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
        echo CJSON::encode(array('objects' => $objects,
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
        echo CJSON::encode(array('objects' => $objects,
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
        echo CJSON::encode(array('objects' => $objects,
            'panel' => $dataSource->renderObjectForm(array('model' => $model, 'currentUrl' => $backUrl, 'backUrl' => $backUrl))));
    }

    public function actionEditPlace($id) {
        $model = $this->loadPlace($id);
        if (isset($_POST['Place'])) {
            $model->setAttributes($_POST['Place']);
            if ($model->validate() && $model->save()) {

                Yii::app()->user->setFlash('edit', 'Place update successful');
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
        echo CJSON::encode(array('objects' => $objects,
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
        echo CJSON::encode(array('objects' => $objects,
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