<?php

class DataExchangeModule extends CWebModule
{

    /**
     * @property string the base url to Rights. Override when module is nested.
     */
    public $baseUrl = '/dataexchange';

    public $formatsAlias = 'dataexchange.formats';

    public $formats = array();

    private $_dataSources = array();
    private $_categories = array();

    public function init()
    {
        $formats = array();
        foreach ($this->formats as $format)
        {
            $formats[] = 'dataexchange.formats.' . $format . '.DE' . $format;
        }
        $this->_categories['Area']=array();
        $this->_categories['Place']=array();
        $this->_categories['Route']=array();
        $this->setImport(CMap::mergeArray($formats,
                        array(
                    'dataexchange.models.*',
                    'dataexchange.components.*',
                )));
    }

    public function save(DataSource $dataSource, array $data)
    {
            foreach ($data['routes'] as $route)
            {
                if(!$dataSource->pending)
                    $this->saveObject($dataSource, $route);
                else
                    $this->saveObjectPending($dataSource, $route);
            }
            foreach ($data['areas'] as $area)
            {
                if(!$dataSource->pending)
                    $this->saveObject($dataSource, $area);
                else
                    $this->saveObjectPending($dataSource, $area);
            }
            foreach ($data['places'] as $place)
            {
                if(!$dataSource->pending)
                    $this->saveObject($dataSource, $place);
                else
                    $this->saveObjectPending($dataSource, $place);
            }
            Yii::app()->cache->flush();
    }

    public function getDataSource($format)
    {
        if (!isset($this->_dataSources[$format]))
        {
            $class = 'DE' . $format;
            $this->_dataSources[$format] = new $class();
            $this->_dataSources[$format]->format = $format;
        }
        return $this->_dataSources[$format];
    }
    public function getCategoryArea($name)
    {
        if (!isset($this->_categories['Area'][$name]))
        {
            $this->_categories['Area'][$name] = $model = CategoryArea::model()->findByAttributes(array('name'=>$name));
        }
        return $this->_categories['Area'][$name];
    }
    public function getCategoryRoute($name)
    {
        if (!isset($this->_categories['Route'][$name]))
        {
            $this->_categories['Route'][$name] = $model = CategoryRoute::model()->findByAttributes(array('name'=>$name));
        }
        return $this->_categories['Route'][$name];
    }
    public function getCategoryPlace($name)
    {
        if (!isset($this->_categories['Place'][$name]))
        {
            $this->_categories['Place'][$name] = CategoryPlace::model()->findByAttributes(array('name'=>$name));
        }
        return $this->_categories['Place'][$name];
    }
    public function getAllCategoryRoute()
    {
        $model = CategoryRoute::model()->findAll();
        foreach($model as $category)
        {
            $this->_categories['Route'][$category->name]  = $category;
        }
        return $this->_categories['Route'];
    }
    public function getAllCategoryPlace()
    {
        $model = CategoryPlace::model()->findAll();
        foreach($model as $category)
        {
            $this->_categories['Place'][$category->name]  = $category;
        }
        return $this->_categories['Place'];
    }
    public function getAllCategoryArea()
    {
        $model = CategoryArea::model()->findAll();
        foreach($model as $category)
        {
            $this->_categories['Area'][$category->name]  = $category;
        }
        return $this->_categories['Area'];
    }
    
    
    private function saveObject(DataSource $dataSource, $object)
    {
        $object->info->format = $dataSource->format;
        $object->validate();
        $object->save();
    }

    private function saveObjectPending(DataSource $dataSource, $object)
    {
        
        $class = get_class($object);
        if (strpos($class, 'Pending') === false)
        {
            $class.='Pending';
        }
        $pendingObject = new $class;
        $pendingObject->unsetAttributes();
        $pendingObject->cloneObject($object);
        $pendingObject->info->format = $dataSource->format;
        $pendingObject->save();
    }
    

}
