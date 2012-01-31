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
     * Route sections
     * @var array
     */
    public $sections;
    
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
            array('_id, authorId, category, info, style', 'safe'),
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
    public function indexes()
    {
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
    public function embeddedDocuments()
    {
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
    public function search($pagination=array())
    {
        $criteria = new CMongoCriteria();
        $criteria->compare('_id', $this->_id, 'MongoId', false);
        $criteria->compare('authorId', $this->authorId, 'MongoId', false);
        $criteria->compare('category', $this->category, 'MongoId', false);
        //info data filters
        foreach($this->info->data as $field=>$value)
        {
            $criteria->compare('info.data.'.$field, $value);
        }
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
    
    public function exportView()
    {
        return array(
            'id'=>  $this->id,
            'author'=> (string)$this->authorId,
            'category'=>  $this->category,
            'points'=> $this->exportPoints(),
        );
    }
    protected function exportPoints()
    {
        $points = array();
        foreach($this->points as $point)
        {
            $points[$point->order] = $point->exportView();
        }
        return $points;
    }
}



