<?php

/**
 * Description of GFBase
 *
 * @name GFBase
 * @author Grzegorz Bliżycki <grzegorzblizycki@gmail.com>
 * @todo 
 * Created: 2011-12-07
 */
abstract class GFBase extends CInputWidget
{
    public $options = array();
    public $debug=true;
    private $assets;
    public function init()
    {
        parent::init();
        if ($this->assets === null)
        {
            if ($this->debug)
            {
                $this->assets = Yii::app()->assetManager->publish(dirname(__FILE__) . DIRECTORY_SEPARATOR . 'assets',
                        false, -1, true);
            }
            else
            {
                $this->assets = Yii::app()->assetManager->publish(dirname(__FILE__) . DIRECTORY_SEPARATOR . 'assets');
            }
        }
        Yii::app()->clientScript
                ->registerCoreScript('jquery')
                ->registerScriptFile($this->assets . '/GFilters.js',CClientScript::POS_END)
                ->registerCssFile($this->assets . '/GFilters.css');
    }
}

