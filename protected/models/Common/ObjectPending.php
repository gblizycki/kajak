<?php

/**
 * Description of ObjectPending
 *
 * @name ObjectPending
 * @author Grzegorz Bliżycki <grzegorzblizycki@gmail.com>
 * @todo 
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
}

