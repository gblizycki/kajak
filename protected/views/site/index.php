<?php

/**
 * @name index
 * @author Grzegorz Bliżycki <grzegorzblizycki@gmail.com>
 * @todo 
 * Created: 2011-12-18
 */
?>
<?php
$this->widget('ext.gmap.gmap',array('options'=>array(
    'baseUrl'=>Yii::app()->baseUrl,
    'iconUrl'=>Yii::app()->baseUrl.'/css/icons.png'
)));
?>
