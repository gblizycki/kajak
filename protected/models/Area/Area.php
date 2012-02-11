<?php

/**
 * Description of Area
 * @name Area
 * @author Grzegorz Bliżycki <grzegorzblizycki@gmail.com>
 */
class Area extends CMongoDocument
{

    /**
     * Points defining the area border
     * @var array
     */
    public $points;

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
     * @var MongoId Area category id (@see CategoryArea)
     */
    public $category;

    /**
     *
     * @var array
     */
    public $style;

    /**
     * Returns the static model of the specified AR class.
     * @return UserRights the static model class
     */
    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }

    /**
     * @return string the associated collection name
     */
    public function getCollectionName()
    {
        return 'area';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        return array(
            array('points, createDate, updateDate, info, style,category', 'safe')
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels()
    {
        return array(
            'points' => 'Punkty',
            'createDate' => 'Data stworzenia',
            'updateDate' => 'Data modyfikacji',
        );
    }

    /**
     * returns array of behaviors
     * @return array
     */
    public function behaviors()
    {
        return array(
            'cachceclear' => array(
                'class' => 'ext.CCacheClearBehavior.CCacheClearBehavior',
                'cacheId' => 'cache',
            ),
            'points' => array(
                'class' => 'ext.YiiMongoDbSuite.extra.EEmbeddedArraysBehavior',
                'arrayPropertyName' => 'points',
                'arrayDocClassName' => 'Point'
            ),
            'timestamp' => array(
                'class' => 'zii.behaviors.CTimestampBehavior',
                'createAttribute' => 'createDate',
                'updateAttribute' => 'updateDate',
                'setUpdateOnCreate' => true,
                'timestampExpression' => 'new MongoDate()'
            ),
            'MongoTypes' => array(
                'class' => 'CMongoTypeBehavior',
                'attributes' => array(
                    'createDate' => 'MongoDate',
                    'updateDate' => 'MongoDate',
                    'style' => 'array',
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
        );
    }

    /**
     * Simple search by attributes
     * @param array $pagination
     * @return CMongoDocumentDataProvider 
     */
    public function search($pagination = array())
    {
        $criteria = new CMongoCriteria();
        $criteria->compare('_id', $this->_id, 'MongoId', false);
        $criteria->compare('category', $this->category, 'MongoId', false);
        $criteria->compare('createDate', $this->createDate, 'MongoDate');
        $criteria->compare('updateDate', $this->updateDate, 'MongoDate');
        $criteria->setSort(array('info.name' => CMongoCriteria::SORT_ASC));
        return new CMongoDocumentDataProvider(get_class($this), array(
                    'criteria' => $criteria,
                    'pagination' => $pagination,
                ));
    }

    /**
     * Export object in appropriate format
     * @return array
     */
    public function exportView()
    {
        $value = Yii::app()->cache->get(get_class($this) . $this->id);
        if ($value === false)
        {
            $value = array(
                'id' => $this->id,
                'points' => $this->exportPoints(),
                'category' => (string) $this->category
            );
            Yii::app()->cache->set(get_class($this) . $this->id, $value, 5000);
        }
        return $value;
    }

    /**
     * Return all hidden fields related to this object
     * @return array 
     */
    public function getHiddenFields()
    {
        $fields = array();
        foreach ($this->points as $index => $point)
        {
            $fields['points[' . $index . '][location][0]'] = array();
            $fields['points[' . $index . '][location][1]'] = array();
            $fields['points[' . $index . '][order]'] = array('class' => 'order');
        }
        return $fields;
    }

    public function save($runValidation = true, $attributes = null)
    {
        Yii::app()->cache->flush();
        parent::save($runValidation, $attributes);
    }

    protected function exportPoints()
    {
        $points = array();
        foreach ($this->points as $point)
        {
            $points[$point->order] = $point->exportView();
        }
        return $points;
    }

}

