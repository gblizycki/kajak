<?php

/**
 * Description of Point
 *
 * @name Point
 * @author Grzegorz Bliżycki <grzegorzblizycki@gmail.com>
 * @todo 
 * Created: 2011-12-21
 */
class Point extends CMongoEmbeddedDocument
{

    /**
     * @var array (longitude, latitude)
     */
    public $location;

    /**
     *
     * @var MongoId linked place for this point
     */
    public $places;

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
     * returns array of behaviors
     * @return array
     */
    public function behaviors()
    {
        return array(
            'MongoTypes' => array(
                'class' => 'CMongoTypeBehavior',
                'attributes' => array(
                    'location' => 'GeoPoint',
                    'places'=>'array.MongoId',
                ),
            ),
        );
    }

}

