<?php

/**
 * Description of CategoryRoute
 *
 * @name CategoryRoute
 * @author Grzegorz Bliżycki <grzegorzblizycki@gmail.com>
 * @package models 
 * Created: 2011-12-21
 */
class CategoryRoute extends Category
{
    /**
     * Returns the static model of the specified AR class.
     * @return UserRights the static model class
     */
    public static function model($className=__CLASS__)
    {
        return parent::model($className);
    }

    /**
     * @return string the associated collection name
     */
    public function getCollectionName()
    {
        return 'categoryroute';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        return CMap::mergeArray(parent::rules(),array(
        ));
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels()
    {
        return CMap::mergeArray(parent::attributeLabels(),array(
        ));
    }

    /**
     * returns array of behaviors
     * @return array
     */
    public function behaviors()
    {
        return CMap::mergeArray(parent::behaviors(),array(
        ));
    }

    /**
     * returns array of indexes
     * @return array
     */
    public function indexes()
    {
        return CMap::mergeArray(parent::indexes(),array(
        ));
    }

    /**
     * returns embedded documents
     * @return array
     */
    public function embeddedDocuments()
    {
        return CMap::mergeArray(parent::embeddedDocuments(),array(
        ));
    }
}

