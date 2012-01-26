<?php

Yii::import('ext.filters.GFBase');

/**
 * Description of GFDropDown
 *
 * @name GFDropDown
 * @author Grzegorz Bliżycki <grzegorzblizycki@gmail.com>
 * @todo 
 * Created: 2011-12-07
 */
class GFDropDown extends GFBase
{
    public $data=array();
    public $emptyElement = null;
    public function init()
    {
        parent::init();
        $this->htmlOptions = CMap::mergeArray($this->htmlOptions, array(
            'class'=>'gfdropdown'
        ));
        if($this->emptyElement!==null)
        {
            $this->data[null]= $this->emptyElement;
        }
    }

    public function run()
    {
        $this->render('main');
    }

}

