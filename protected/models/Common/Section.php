<?php

/**
 * Description of Point
 *
 * @name Point
 * @author Grzegorz Bliżycki <grzegorzblizycki@gmail.com>
 * @todo 
 * Created: 2011-12-21
 */
class Section extends CMongoEmbeddedDocument
{
    /**
     * Route points
     * @var array
     */
    public $points;
    
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
            'points' => array(
                'class' => 'ext.YiiMongoDbSuite.extra.EEmbeddedArraysBehavior',
                'arrayPropertyName' => 'points',
                'arrayDocClassName' => 'Point'
            ),
            'MongoTypes' => array(
                'class' => 'CMongoTypeBehavior',
                'attributes' => array(
                    
                ),
            ),
        );
    }

    /**
     * @return float Longitude
     */
    public function getLongitude()
    {
        return $this->location[0];
    }

    /**
     * @return float Latitude
     */
    public function getLatitude()
    {
        return $this->location[1];
    }

    /**
     * Return encoded object to json format
     * @return array 
     */
    public function getExportAttributes()
    {
        return array(
            'location'=>'array.float',
            'order'=>'int',
            'info'=>'',
            'style'=>''
        );
    }

    public function exportView()
    {
        return array(
            'order'=> $this->order,
            'latitude'=>  $this->latitude,
            'longitude'=>  $this->longitude,
            'info'=>  $this->exportInfo(),
        );
    }
    
    protected function exportInfo()
    {
        return array(
            'name'=>  $this->info->name,
            'description'=>  $this->info->description,
        );
    }
}

