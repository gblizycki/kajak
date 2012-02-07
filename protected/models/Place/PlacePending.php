<?php

/**
 * Description of Place
 *
 * @name Place
 * @author Grzegorz Bliżycki <grzegorzblizycki@gmail.com>
 * @todo 
 * Created: 2011-12-21
 */
class PlacePending extends ObjectPending
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

    public $style;
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
        return 'placepending';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        return CMap::mergeArray(parent::rules(), array(
            array('address, authorId, type, category', 'safe'),
        ));
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels()
    {
        return CMap::mergeArray(parent::attributeLabels(), array(
            'address' => 'Adres',
            'authorId' => 'Autor',
            'type' => 'Typ',
            'category' => 'Kategoria',
        ));
    }

    /**
     * returns array of behaviors
     * @return array
     */
    public function behaviors()
    {
        return CMap::mergeArray(parent::behaviors(), array(
            'MongoTypes' => array(
                'class' => 'CMongoTypeBehavior',
                'attributes' => array(
                    'address' => 'string',
                    'authorId' => 'MongoId',
                    'type' => 'string',
                    'category' => 'MongoId',
                    'style'=>'array'
                ),
            ),
        ));
    }

    /**
     * returns array of indexes
     * @return array
     */
    public function indexes()
    {
        return CMap::mergeArray(parent::indexes(), array(
            'location' => array(
                // key array holds list of fields for index
                // you may define multiple keys for index and multikey indexes
                // each key must have a sorting direction SORT_ASC or SORT_DESC
                'key' => array(
                    'location.location' => CMongoCriteria::INDEX_2D,
                ),
            ),
        ));
    }

    /**
     * returns embedded documents
     * @return array
     */
    public function embeddedDocuments()
    {
        return CMap::mergeArray(parent::embeddedDocuments(), array(
            'info' => 'Info',
            'location' => 'Point',
        ));
    }

    /**
     * Simple search by attributes
     * @param array $pagination
     * @return CMongoDocumentDataProvider 
     */
    public function search($pagination=array())
    {
        $criteria = new CMongoCriteria();
        $criteria->compare('_id', $this->_id, 'MongoId', true);
        $criteria->compare('address', $this->address, 'string', true);
        $criteria->compare('authorId', $this->authorId, 'MongoId', true);
        $criteria->compare('type', $this->type, 'string', true);
        $criteria->compare('category', $this->category, 'MongoId', true);
        $sort = new CSort();
        $sort->attributes = array(
            'defaultOrder' => '_id DESC',
            '_id',
            'address',
            'authorId',
            'type',
            'category',
        );
        return new CMongoDocumentDataProvider(get_class($this), array(
                    'criteria' => $criteria,
                    'sort' => $sort,
                    'pagination' => $pagination,
                ));
    }
}

