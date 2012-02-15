<?php

/**
 * Description of Info
 *
 * @name Info
 * @author Grzegorz Bliżycki <grzegorzblizycki@gmail.com>
 * @package models 
 * Created: 2011-12-21
 */
class Info extends CMongoEmbeddedDocument
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
     * @var mixed Array of undefined data type e.g. url's, id's, ...
     */
    public $photos=array();
    
    /**
     * Optional data added
     * @var array
     */
    public $data=array();
    
    /**
     *
     * @var string DataSource format
     */
    public $format;
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
                    'description' => 'string',
                    'title' => 'string',
                    'photos' => 'array',
                    'data'=>'array',
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
            array('photos, data','ext.JSONInput.JSONValidator'),
            array('name, description, title, photos, data,format', 'safe')
        );
    }
    
    
    public function __toString()
    {
        return str_replace('\u', '&#x', CJSON::encode($this->attributes));
    }
    /**
     * Return encoded object to json format
     * @return array 
     */
    public function getExportAttributes()
    {
        return array(
            'name'=>'string',
            //'description'=>'array',
            'title'=>'string',
            //'data'=>'array',
        );
    }

}

