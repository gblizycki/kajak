<?php

Yii::import('ext.filters.GFBase');

/**
 * Description of GFSlider
 *
 * @name GFSlider
 * @author Grzegorz Bliżycki <grzegorzblizycki@gmail.com>
 * @todo implement view with jui slider
 * Created: 2011-12-07
 */
class GFText extends GFBase
{

    public function init()
    {
        parent::init();
    }

    public function run()
    {
        $this->render('main');
    }

}

