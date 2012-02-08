<?php

/**
 * Description of Category
 *
 * @name Category
 * @author Grzegorz Bliżycki <grzegorzblizycki@gmail.com>
 * @todo 
 * Created: 2011-12-21
 */
abstract class Category extends CMongoDocument
{

    /**
     * @var string
     */
    public $name;

    /**
     * @var string
     */
    public $description;

    /**
     * @var string If title is null then name become title
     */
    public $title;

    /**
     * @var array Array of filters (@see Filter)
     */
    public $filters;
    
    public $style;

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        return array(
            array('style','ext.JSONInput.JSONValidator'),
            array('_id, name, description, title,style', 'safe'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels()
    {
        return array(
            'name' => 'Nazwa',
            'description' => 'Opis',
            'title' => 'Tytuł',
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
                    'name' => 'string',
                    'description' => 'string',
                    'title' => 'string',
                    'style'=>'array',
                ),
            ),
            'filters' => array(
                'class' => 'ext.YiiMongoDbSuite.extra.EEmbeddedArraysBehavior',
                'arrayPropertyName' => 'filters',
                'arrayDocClassName' => 'Filter'
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

    /**
     * Simple search by attributes
     * @param array $pagination
     * @return CMongoDocumentDataProvider 
     */
    public function search($pagination=array())
    {
        $criteria = new CMongoCriteria();
        $criteria->compare('_id', $this->_id, 'MongoId', false);
        $criteria->compare('name', $this->name, 'string', true);
        $criteria->compare('description', $this->description, 'string', true);
        $criteria->compare('title', $this->title, 'string', true);
        $sort = new CSort();
        $sort->attributes = array(
            'defaultOrder' => '_id DESC',
            '_id',
            'name',
            'description',
            'title',
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
            'name'=>  $this->name,
            'style'=>  $this->style
        );
    }

}

