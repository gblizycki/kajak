<?php

/**
 * Description of ObjectPending
 *
 * @name ObjectPending
 * @author Grzegorz Bliżycki <grzegorzblizycki@gmail.com>
 * @package models 
 * Created: 2011-12-29
 */
abstract class ObjectPending extends CMongoDocument
{

    /**
     * Parent object (Route, Place, Place) for replacing
     * with new data
     * @var MongoId
     */
    public $objectId;

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        return array(
            array('objectId', 'safe')
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels()
    {
        return array(
            'objectId' => 'Obiekt główny',
        );
    }

    /**
     * returns array of behaviors
     * @return array
     */
    public function behaviors()
    {
        return array(
        );
    }

    /**
     * returns array of indexes
     * @return array
     */
    public function indexes()
    {
        return array(
        );
    }

    /**
     * returns embedded documents
     * @return array
     */
    public function embeddedDocuments()
    {
        return array(
        );
    }

    public function cloneObject($object)
    {
        $this->initEmbeddedDocuments();
        //bad hack for initialized embedded documents
        $class = get_class($object);
        $fakeObject = new $class();
        foreach ($fakeObject->attributes as $atr => $value)
        {
            if ($object->{$atr} !== null)
            {
                if ($atr != '_id')
                {
                    $this->{$atr} = $object->{$atr};
                }
                else
                {
                    $this->objectId = $object->{$atr};
                }
            }
        }
    }

    public function getOrginalObject()
    {
        if ($this->objectId === null)
        {
            $class = get_class($this);
            $class = str_replace('Pending', '', $class);
            return new $class();
        }
        $criteria = new CMongoCriteria;
        $criteria->compare('_id', $this->objectId, 'MongoId');
        return CMongoDocument::model(get_class($this))->find($criteria);
    }

    public function accept()
    {
        $model = $this->OrginalObject;
//        $class = get_class($this);
//        $class = str_replace('Pending', '', $class);
//        if ($object === null)
//        {
//            //insert as new
//            $model = new $class();
//        }
//        else
//        {
//            $model = $object;
//        }
        $class = get_class($this);
        $fakeObject = new $class();
        foreach ($fakeObject->attributes as $atr => $value)
        {
            if ($this->{$atr} !== null)
            {
                if ($atr != '_id' && $atr != 'ObjectId')
                {
                    $model->{$atr} = $this->{$atr};
                }
            }
        }
        return $model;
    }

}

