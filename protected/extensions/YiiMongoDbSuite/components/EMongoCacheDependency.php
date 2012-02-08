<?php
Yii::import('system.caching.dependencies.CCacheDependency');
class EMongoCacheDependency extends CCacheDependency
{
﻿  

﻿  public function __construct($model=null,$attribute=null,$connectionID=null)
﻿  {
    $this->model = $model;
    $this->attribute = $attribute;
    if($connectionID===null)
        $connectionID ='mongodb';
    $this->connectionID = $connectionID;
﻿  }

﻿  /**
﻿   * PHP sleep magic method.
﻿   * This method ensures that the database instance is set null because it contains resource handles.
﻿   * @return array
﻿   */
﻿  public function __sleep()
﻿  {
﻿  ﻿  $this->_db=null;
﻿  ﻿  return array_keys((array)$this);
﻿  }

﻿  /**
﻿   * Generates the data needed to determine if dependency has been changed.
﻿   * This method returns the value of the global state.
﻿   * @return mixed the data needed to determine if dependency has been changed.
﻿   */
﻿  protected function generateDependentData()
﻿  {
﻿  ﻿  if($this->model!==null && $this->attribute!==null)
﻿  ﻿  {
﻿  ﻿  ﻿  $db=$this->getDbConnection();
      $criteria = new EMongoCriteria();
      $criteria->select(array($this->attribute));
      $criteria->sort($this->attribute, $this->order);
      $criteria->limit(1);
﻿  ﻿  ﻿  if($db->queryCachingDuration>0)
﻿  ﻿  ﻿  {
﻿  ﻿  ﻿  ﻿  // temporarily disable and re-enable query caching
﻿  ﻿  ﻿  ﻿  $duration=$db->queryCachingDuration;
﻿  ﻿  ﻿  ﻿  $db->queryCachingDuration=0;
﻿  ﻿  ﻿  ﻿  $result=$model->findOne($criteria)->{$this->attribute};
﻿  ﻿  ﻿  ﻿  $db->queryCachingDuration=$duration;
﻿  ﻿  ﻿  }
﻿  ﻿  ﻿  else
﻿  ﻿  ﻿  ﻿  $result=$model->findOne($criteria)->{$this->attribute};
﻿  ﻿  ﻿  return $result;
﻿  ﻿  }
﻿  ﻿  else
﻿  ﻿  ﻿  throw new CException(Yii::t('yii','CDbCacheDependency.sql cannot be empty.'));
﻿  }

﻿  /**
﻿   * @return CDbConnection the DB connection instance
﻿   * @throws CException if {@link connectionID} does not point to a valid application component.
﻿   */
﻿  protected function getDbConnection()
﻿  {
﻿  ﻿  if($this->_db!==null)
﻿  ﻿  ﻿  return $this->_db;
﻿  ﻿  else
﻿  ﻿  {
﻿  ﻿  ﻿  if(($this->_db=Yii::app()->getComponent($this->connectionID)) instanceof CDbConnection)
﻿  ﻿  ﻿  ﻿  return $this->_db;
﻿  ﻿  ﻿  else
﻿  ﻿  ﻿  ﻿  throw new CException(Yii::t('yii','CDbCacheDependency.connectionID "{id}" is invalid. Please make sure it refers to the ID of a CDbConnection application component.',
﻿  ﻿  ﻿  ﻿  ﻿  array('{id}'=>$this->connectionID)));
﻿  ﻿  }
﻿  }
}
?>
