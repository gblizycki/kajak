<?php

/**
 * Description of Style
 *
 * @name Style
 * @author Grzegorz Bliżycki <grzegorzblizycki@gmail.com>
 * @todo 
 * Created: 2011-12-21
 */
class Style extends CMongoEmbeddedDocument
{

    /**
     * @var string
     */
    public $color;

    /**
     * @var string
     */
    public $marker;

    /**
     * @var double Line thickness
     */
    public $thickness;

    /**
     * Optional data added
     * @var array
     */
    public $data=array();

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
                    'color' => 'string',
                    'marker' => 'string',
                    'thickness' => 'string',
                    'data' => 'array',
                ),
            ),
        );
    }
    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        return array(
            array('data','ext.JSONInput.JSONValidator'),
            array('color, marker, thickness', 'safe')
        );
    }
    
    public function __toString()
    {
        return str_replace('\u', '&#x', CJSON::encode($this->attributes));
    }

}

