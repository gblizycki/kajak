<?php

/**
 * Description of Filter
 *
 * @name Filter
 * @author Grzegorz Bliżycki <grzegorzblizycki@gmail.com>
 * @todo 
 * Created: 2011-12-22
 */
class Filter extends CMongoEmbeddedDocument
{

    /**
     * @var string Filter title/name
     */
    public $name;

    /**
     * @var string Model attribute for this filter
     */
    public $attribute;

    /**
     * @var string Class of this filter
     */
    public $class;

    /**
     * @var array Options passed to filter (widget) constructor
     */
    public $options = array();

    /**
     * @var int Filter order in filter bar 
     */
    public $order;

    public $type = 'string';
    public $partialMatch = false;
    /**
     * Optional data for widget e.g. drop down data source
     * If it's array widget use direct
     * Otherwise (string) use it's as a property name for source data from model
     * Uses dot notation for accessing sub property name
     * @example
     *     'data'=>'group.availableGroups'
     *     $model->group->availableGroups
     * @var mixed Widget data
     */
    public $data;

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        return array(
            array('name, attribute, class, order', 'required'),
            array('order', 'numerical', 'numerical', 'integerOnly' => false),
            array('options, data', 'safe'),
            array('name, attribute, class, options, data', 'safe', 'on' => 'search'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels()
    {
        return array(
            'name' => 'Name',
            'attribute' => 'Attribute',
            'class' => 'Class',
            'options' => 'Options',
            'order' => 'Order',
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
                    'name' => 'string',
                    'attribute' => 'string',
                    'class' => 'string',
                    'options' => 'array',
                    'order' => 'int',
                ),
            ),
        );
    }
    
    public function setFilter(CMongoCriteria $criteria,$object)
    {
        $value = CHtml::resolveValue($object, $this->attribute);
        $attribute = $this->transformAttribute();
        $criteria->compare($this->transformAttribute(), CHtml::resolveValue($object, $this->attribute),  $this->type,$this->partialMatch);
    }
    protected function transformAttribute()
    {
        return str_replace(array('[',']'), array('.',''), $this->attribute);
    }

}

