<?php

/**
 * Description of Place
 *
 * @name Place
 * @author Grzegorz Bliżycki <grzegorzblizycki@gmail.com>
 * @todo 
 * Created: 2011-12-21
 */
class Place extends CMongoDocument
{

    /**
     * @var string Address for this place
     */
    public $address;

    /**
     * @var MongoId Author id (@see User) 
     */
    public $authorId;

    /**
     * @var string Type of this place e.g. ('Hotel','Wypożyczalnia')
     */
    public $type;

    /**
     * @var MongoId Place category id (@see CategoryPlace)
     */
    public $category;

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
        return 'place';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        return array(
            array('address, authorId, type, category', 'safe'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels()
    {
        return array(
            'address' => 'Adres',
            'authorId' => 'Autor',
            'type' => 'Typ',
            'category' => 'Kategoria',
        );
    }

    /**
     * returns array of behaviors
     * @return array
     */
    public function behaviors()
    {
        return array(
            'MongoTypes' => array(
                'class' => 'CMongoTypeBehavior',
                'attributes' => array(
                    'address' => 'string',
                    'authorId' => 'MongoId',
                    'type' => 'string',
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
            'location' => array(
                // key array holds list of fields for index
                // you may define multiple keys for index and multikey indexes
                // each key must have a sorting direction SORT_ASC or SORT_DESC
                'key' => array(
                    'location.location' => CMongoCriteria::INDEX_2D,
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
            'location' => 'Point',
        );
    }

}

