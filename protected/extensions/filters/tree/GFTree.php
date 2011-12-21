<?php

Yii::import('ext.filters.GFBase');

/**
 * Description of GFTree
 *
 * @name GFTree
 * @author Grzegorz Bliżycki <grzegorzblizycki@gmail.com>
 * @todo implement
 * Created: 2011-12-07
 */
class GFTree extends GFBase
{

    public $data = array();

    public $nameProperty = 'name';

    public $valueProperty = 'id';

    public $relation = 'SubCategory';
    
    public $parentRelation = 'parentId';

    public $modelName = 'ProductCategory';

    public $formModel = null;
    
    public $formModelAttribute;
    
    protected $_elements = array();
    
    protected $_actual = null;
    
    protected $_prev = null;

    public function init()
    {
        parent::init();
        //$all = model()->findAll();
        //$this->_actual = $this->model->{$this->valueProperty};
        //var_dump($this->model);die();
        $this->_actual = $this->model->{$this->valueProperty};
        $all = CMongoDocument::model($this->modelName)->findAll();
        foreach ($all as $m)
        {
            $this->_elements[$m->id] = $m;
        }
        if($this->_actual===null)
        {
            foreach($this->_elements as $e)
                if($e->parentId===null)
                {
                    $this->_actual = $e->id;
                    break;
                }
        }
        $this->_prev = $this->_elements[(string)$this->_actual]->{$this->valueProperty};
        $this->data = $this->buildData(null);
    }

    public function run()
    {
        $this->render('main');
    }

    public function buildData($model)
    {
        $subs = $this->relatedData($model);
        $subChildren = array();
        foreach($subs as $element)
        {
            $subChildren[] = $this->buildData($element);
        }
        $class = 'hidden';
        if($model->{$this->valueProperty}==$this->_actual)
                $class = 'actual';
        
        if($model===null)
            return $subChildren;
        return array(
            'name' => $model->{$this->nameProperty},
            'value' => $model->{$this->valueProperty},
            'parent'=> $model->{$this->parentRelation},
            'subs' => $subChildren,
            'class'=>$class,
        );
    }
    
    private function relatedData($model)
    {
        $returnArray = array();
        foreach($this->_elements as $e)
        {
            if($e->{$this->parentRelation} == $model->{$this->valueProperty})
                $returnArray[] = $e;
        }
        return $returnArray;
    }

}

