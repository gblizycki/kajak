<?php

/**
 * Description of Section
 *
 * @name Section
 * @author Grzegorz Bliżycki <grzegorzblizycki@gmail.com>
 * @todo 
 * Created: 2011-12-21
 */
class Section extends CMongoEmbeddedDocument
{
    /**
     * Section points
     * @var array
     */
    public $points;
    /**
     * Section oreder
     * @var int 
     */
    public $order;
    public $style;
    /**
     * returns embedded documents
     * @return array
     */
    public function embeddedDocuments()
    {
        return array(
            'info' => 'Info',
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
                    'order'=>'int',
                    'style'=>'array'
                ),
            ),
        );
    }
    public function rules() {
        return array(
            array('order, points,style','safe'),
        );
    }
    /**
     * Return encoded object to json format
     * @return array 
     */
    public function getExportAttributes()
    {
        return array(
            'order'=>'int',
            'points'=> $this->exportPoints(),
            'info'=>'',
            'style'=>''
        );
    }

    public function exportView()
    {
        return array(
            'order'=> $this->order,
            'info'=>  $this->exportInfo(),
            'points'=>$this->exportPoints(),
        );
    }
    
    protected function exportInfo()
    {
        return array(
            'name'=>  $this->info->name,
            'description'=>  $this->info->description,
        );
    }
    protected function exportPoints()
    {
        $points = array();
        $this->toArray();
        foreach($this->points as $point)
        {
            $points[$point->order] = $point->exportView();
        }
        return $points;
    }
    
    public function getHiddenFields($sectionIndex)
    {
        $fields = array();
        foreach($this->points as $index=>$point)
        {
            $fields[ 'sections['.$sectionIndex.'][points]['.$index.'][location][0]']= array('class'=>'section-'.$this->order);
            $fields['sections['.$sectionIndex.'][points]['.$index.'][location][1]'] = array('class'=>'section-'.$this->order);
            $fields['sections['.$sectionIndex.'][points]['.$index.'][order]']= array('class'=>'order section-'.$this->order);
        }
        return $fields;
    }
}

