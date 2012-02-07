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
    public $inputId;
    public $slideEnable = false;
    public $slide;
    private $assets;
    public function init()
    {
        parent::init();
        if($this->slideEnable)
        {
            $this->inputId = str_replace(array('[',']','.'),array('-','',''),get_class($this->model).'-'.$this->attribute);
            if(isset($_GET[$this->inputId]))
                $this->slide = $_GET[$this->inputId];
            elseif(isset($_POST[$this->inputId]))
                $this->slide = $_POST[$this->inputId];
            else
                $this->slide = 1;
        }
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

