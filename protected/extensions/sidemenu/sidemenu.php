<?php

/**
 * Description of sidemenu
 *
 * @name sidemenu
 * @author Grzegorz Bliżycki <grzegorzblizycki@gmail.com>
 * @todo 
 * Created: 2011-12-29
 */
Yii::import('zii.widgets.CPortlet');
class sidemenu extends CPortlet
{
    public $items = array();
 
    protected function renderContent()
    {
        $this->render('menu');
    }
}

