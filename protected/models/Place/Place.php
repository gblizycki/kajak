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
     * @var array.MongoId Place category id (@see CategoryPlace)
     */
    public $category;
    
    public $style;
    
        /**
     * Create date
     * @var MongoDate
     */
    public $createDate;

    /**
     * Modyfication/update date
     * @var MongoDate
     */
    public $updateDate;
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
            array('address, authorId, type, category,info, style,location,createDate,updateDate', 'safe'),
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
            'cachceclear'=>array(
                'class'=>'ext.CCacheClearBehavior.CCacheClearBehavior',
                'cacheId'=>'cache',
            ),
            'MongoTypes' => array(
                'class' => 'CMongoTypeBehavior',
                'attributes' => array(
                    'address' => 'string',
                    'category' => 'array.MongoId',
                    'style'=>'array'
                ),
            ),
            'timestamp' => array(
                'class' => 'zii.behaviors.CTimestampBehavior',
                'createAttribute' => 'createDate',
                'updateAttribute' => 'updateDate',
                'setUpdateOnCreate' => true,
                'timestampExpression' => 'new MongoDate()'
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
            'location' => 'Point',
        );
    }

    /**
     * Simple search by attributes
     * @param array $pagination
     * @return CMongoDocumentDataProvider 
     */
    public function search($pagination=array())
    {
        $criteria = new CMongoCriteria();
        $criteria->compare('_id', $this->_id, 'MongoId', false);
        $criteria->compare('address', $this->address, 'string', true);
        $criteria->compare('authorId', $this->authorId, 'MongoId', false);
        $criteria->compare('type', $this->type, 'string', false);
        $criteria->compare('category', $this->category , 'MongoId',false);
        $criteria->setLimit(1000);
        //$criteria->compare('category', $this->category, 'MongoId', true);
        $criteria->setSort(array('info.name'=>  CMongoCriteria::SORT_ASC));
        //$dependecy = new CDbCacheDependency('SELECT MAX(update_time) FROM {{post}}');
        return new CMongoDocumentDataProvider(get_class($this), array(
                    'criteria' => $criteria,
                    'pagination' => $pagination,
                ));
    }
    
    public function exportAttributes()
    {
        
    }
    public function exportView()
    {
        
        $exportdata = Yii::app()->cache->get('export'.$this->id); 
        if($exportdata===false)
        {
            $exportdata = array(
                'id'=>  $this->id,
                'author'=> (string)$this->authorId,
                'category'=>  $this->exportCategories(),
                'location'=> $this->location->exportView(),
            );
            Yii::app()->cache->set('export'.$this->id, $exportdata, 30);
        }
        return $exportdata;
    }
    
    public function exportCategories()
    {
        $categories = array();
        if(!is_array($this->category))return $categories;
        foreach($this->category as $category)
        {
            $categories[(string)$category] = (string)$category;
        }
        return $categories;
    }
    
    public function getHiddenFields()
    {
        return array(
            'location[location][0]'=>array('class'=>'longitude'),
            'location[location][1]'=>array('class'=>'latitude'),
        );
    }
    public function save($runValidation = true, $attributes = null) {
        Yii::app()->cache->flush();
        parent::save($runValidation, $attributes);
    }
}

