<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of CMongoCacheDependency
 *
 * @author gblizycki
 */
class CMongoCacheDependency extends CCacheDependency{
    public $connectionID='mongodb';
    public $model;
    public $attribute;
    public $order;
    private $_db;
    
    public function __construct($model=null,$attribute=null,$order=null) {
        $this->model = $model;
        $this->attribute = $attribute;
        $this->order = $order;
    }
    
    public function __sleep() {
        $this->_db = null;
        return array_keys((array)  $this);
    }
    protected function generateDependentData() {
        if($this->model!==null && $this->attribute!==null && $this->order!==null)
        {
            $db = $this->getDbConnection();
            $criteria = new EMongoCriteria();
            $criteria->select(array($this->attribute));
            $criteria->sort($this->attribute, $this->order);
            $criteria->limit(1);
                $result=$this->model->find($criteria)->{$this->attribute}->sec;
            return $result;
        }
        else
            throw new CException(Yii::t('yii','CDbCacheDependency.sql cannot be empty.'));
    }
    
    protected function getDbConnection()
    {
        if($this->_db!==null)
            return $this->_db;
        else
        {
            if(($this->_db=Yii::app()->getComponent($this->connectionID)) instanceof EMongoDB)
                return $this->_db;   
            else
                throw new CException(Yii::t('yii','CDbCacheDependency.connectionID "{id}" is invalid. Please make sure it refers to the ID of a CDbConnection application component.',
            array('{id}'=>$this->connectionID)));
        }
            
    }
}

?>
