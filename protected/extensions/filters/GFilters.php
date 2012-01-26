<?php

/**
 * Description of GFilters
 *
 * @name GFilters
 * @author Grzegorz Bliżycki <grzegorzblizycki@gmail.com>
 * @todo 
 * Created: 2011-12-09
 */
class GFilters extends CApplicationComponent
{
    public $map = array();
    
    public function resolveClass($widgetClass)
    {
        if(!isset($this->map[$widgetClass]))
            throw new CException('Widget class unknow: '.$widgetClass);
        return $this->map[$widgetClass];
    }
}

