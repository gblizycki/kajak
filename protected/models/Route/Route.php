<?php

/**
 * Description of Route
 *
 * @name Route
 * @author Grzegorz Bliżycki <grzegorzblizycki@gmail.com>
 * @todo 
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

    /**
     * @var string format of datasource
     */
    public $format;

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
            array('_id, authorId, category, info, style,sections', 'safe'),
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
                ),
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
        $criteria->compare('_id', $this->_id, 'MongoId', false);
        $criteria->compare('authorId', $this->authorId, 'MongoId', false);
        $criteria->compare('category', $this->category, 'MongoId', false);
        $sort = new CSort();
        $sort->attributes = array(
            'defaultOrder' => '_id DESC',
            '_id',
            'authorId',
            'category',
        );
        return new CMongoDocumentDataProvider(get_class($this), array(
                    'criteria' => $criteria,
                    'sort' => $sort,
                    'pagination' => $pagination,
                ));
    }

    public function exportView() {
        return array(
            'id' => $this->id,
            'author' => (string) $this->authorId,
            'category' => $this->category,
            'sections' => $this->exportSections(),
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
        parent::save($runValidation, $attributes);
    }
    public function getAla()
    {
        return null;
    }
}

