<?php

/**
 * Description of Route
 *
 * @name Route
 * @author Grzegorz Bliżycki <grzegorzblizycki@gmail.com>
 * @package models 
 * Created: 2011-12-21
 */
class Route extends CMongoDocument {

    /**
     * @var MongoId Author id (@see User) 
     */
    public $authorId;

    /**
     * @var MongoId Place category id (@see CategoryRoute)
     */
    public $category;

    /**
     * Route sections
     * @var array
     */
    public $sections;
    
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
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    /**
     * @return string the associated collection name
     */
    public function getCollectionName() {
        return 'route';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        return array(
            array('style','ext.JSONInput.JSONValidator'),
            array('_id, authorId, category, info, style,sections,createDate,updateDate', 'safe'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        return array(
            'authorId' => 'Autor',
            'category' => 'Kategoria',
        );
    }

    /**
     * returns array of behaviors
     * @return array
     */
    public function behaviors() {
        return array(
            'cachceclear'=>array(
                'class'=>'ext.CCacheClearBehavior.CCacheClearBehavior',
                'cacheId'=>'cache',
            ),
            'sections' => array(
                'class' => 'ext.YiiMongoDbSuite.extra.EEmbeddedArraysBehavior',
                'arrayPropertyName' => 'sections',
                'arrayDocClassName' => 'Section'
            ),
            'MongoTypes' => array(
                'class' => 'CMongoTypeBehavior',
                'attributes' => array(
                    'authorId' => 'MongoId',
                    'category' => 'MongoId',
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
    public function indexes() {
        return array(
            'points' => array(
                // key array holds list of fields for index
                // you may define multiple keys for index and multikey indexes
                // each key must have a sorting direction SORT_ASC or SORT_DESC
                'key' => array(
                    'sections.points.location' => CMongoCriteria::INDEX_2D,
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
        );
    }

    /**
     * Simple search by attributes
     * @param array $pagination
     * @return CMongoDocumentDataProvider 
     */
    public function search($pagination = array()) {
        $criteria = new CMongoCriteria();
        $criteria->compare('_id', $this->_id, 'MongoId', false);
        $criteria->compare('authorId', $this->authorId, 'MongoId', false);
        $criteria->compare('category', $this->category, 'MongoId', false);
        $criteria->setSort(array('info.name'=>  CMongoCriteria::SORT_ASC));
        return new CMongoDocumentDataProvider(get_class($this), array(
                    'criteria' => $criteria,
                    'pagination' => $pagination,
                ));
    }

    public function exportView() {
        return array(
            'id' => $this->id,
            'author' => (string) $this->authorId,
            'category' => (string)$this->category,
            'sections' => $this->exportSections(),
            'style'=>  $this->style,
        );
    }

    protected function exportSections() {
        $sections = array();
        foreach ($this->sections as $section) {
            $section->toArray();
            $sections[$section->order] = $section->exportView();
            $sections[$section->order]['id'] = $this->id;
        }
        return $sections;
    }
    public function getHiddenFields()
    {
        $fields = array();
        foreach($this->sections as $index=>$section)
        {
            $fields['sections['.$index.'][order]'] = array('class'=>'order-section');
            $fields = CMap::mergeArray($fields, $section->getHiddenFields($index));
        }
        return $fields;
    }
    public function save($runValidation = true, $attributes = null) {
        Yii::app()->cache->flush();
        parent::save($runValidation, $attributes);
    }
}

