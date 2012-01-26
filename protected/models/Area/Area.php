<?php

/**
 * Description of Area
 *
 * @name Area
 * @author Grzegorz Bliżycki <grzegorzblizycki@gmail.com>
 * @todo 
 * Created: 2011-12-21
 */
class Area extends CMongoDocument {

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
     * Returns the static model of the specified AR class.
     * @return UserRights the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    /**
     * @return string the associated collection name
     */
    public function getCollectionName() {
        return 'area';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        return array(
            array('points, createDate, updateDate, info, style', 'safe')
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
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
    public function behaviors() {
        return array(
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
        );
    }

    /**
     * returns array of indexes
     * @return array
     */
    public function indexes() {
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
    public function embeddedDocuments() {
        return array(
            'info' => 'Info',
            'style' => 'Style',
        );
    }

    /**
     * Simple search by attributes
     * @param array $pagination
     * @return CMongoDocumentDataProvider 
     */
    public function search($pagination = array()) {
        $criteria = new CMongoCriteria();
        $criteria->compare('_id', $this->_id, 'MongoId', true);
        $criteria->compare('createDate', $this->createDate, 'MongoDate');
        $criteria->compare('updateDate', $this->updateDate, 'MongoDate');
        $sort = new CSort();
        $sort->attributes = array(
            'defaultOrder' => '_id DESC',
            '_id',
            'createDate',
            'updateDate',
        );
        return new CMongoDocumentDataProvider(get_class($this), array(
                    'criteria' => $criteria,
                    'sort' => $sort,
                    'pagination' => $pagination,
                ));
    }

}

