<?php

/**
 * Description of gmap
 *
 * @name gmap
 * @author Grzegorz Bliżycki <grzegorzblizycki@gmail.com>
 * @todo 
 * Created: 2012-01-03
 */
class gmap extends CWidget
{
    public $baseUrl;
    public $debug = true;
    public function init()
    {
        $this->publishAssets();
        $this->registerClientScripts();
    }
    public function publishAssets()
    {
        $dir = dirname(__FILE__) . DIRECTORY_SEPARATOR . 'assets';
        $this->baseUrl = Yii::app()->getAssetManager()->publish($dir,false,-1,  $this->debug);
    }
    public function registerClientScripts()
    {
        $cs = Yii::app()->getClientScript();
        //js
        $cs->registerCoreScript('jquery');
        $cs->registerScriptFile("http://maps.google.com/maps/api/js?sensor=false",  CClientScript::POS_END);
        $cs->registerScriptFile($this->baseUrl.'/gmap3'.($this->debug?'':'-min').'.js',  CClientScript::POS_END);
        $cs->registerScriptFile($this->baseUrl.'/DEMap'.($this->debug?'':'-min').'.js',  CClientScript::POS_END);
        //css & scss
        $cs->registerCssFile($this->baseUrl.'/DEMap.css');
        //init js
        $cs->registerScript('DEMap','
            $(document).ready(function() {
              $("#DEMap").DEMap();
            });
            ',CClientScript::POS_END);
    }
    public function run()
    {
        $this->render('main');
    }
}

