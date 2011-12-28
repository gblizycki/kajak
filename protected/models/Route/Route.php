<?php

/**
 * Description of Route
 *
 * @name Route
 * @author Grzegorz Bliżycki <grzegorzblizycki@gmail.com>
 * @todo 
 * Created: 2011-12-21
 */
class Route extends CMongoDocument
{

    /**
     * @var MongoId Author id (@see User) 
     */
    public $authorId;
    /**
     * @var MongoId Place category id (@see CategoryRoute)
     */
    public $category;
    
    /**
     * Route points
     * @var array
     */
    public $points;
    
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
        return 'route';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        return array(
            array('authorId, category', 'safe'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels()
    {
        return array(
            'authorId'=>'Autor',
            'category'=>'Kategoria',
        );
    }

    /**
     * returns array of behaviors
     * @return array
     */
    public function behaviors()
    {
        return array(
            'points' => array(
                'class' => 'ext.YiiMongoDbSuite.extra.EEmbeddedArraysBehavior',
                'arrayPropertyName' => 'points',
                'arrayDocClassName' => 'Point'
            ),
            'MongoTypes' => array(
                'class' => 'CMongoTypeBehavior',
                'attributes' => array(
                    'authorId' => 'MongoId',
                    'category' => 'MongoId',
                ),
            ),
        );
    }

    /**
     * returns array of indexes
     * @return array
     */
    public function indexes()
    {
        return array(
            'points' => array(
                // key array holds list of fields for index
                // you may define multiple keys for index and multikey indexes
                // each key must have a sorting direction SORT_ASC or SORT_DESC
                'key' => array(
                    'points.location' => CMongoCriteria::INDEX_2D,
                ),
            ),
        );
    }
    /**
     * returns embedded documents
     * @return array
     */
    public function embeddedDocuments()
    {
        return array(
            'info' => 'Info',
            'style' => 'Style',
        );
    }
}



