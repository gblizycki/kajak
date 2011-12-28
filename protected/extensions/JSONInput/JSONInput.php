<?php

/**
 * Description of JSONInput
 *
 * @name JSONInput
 * @author Grzegorz Bliżycki <grzegorzblizycki@gmail.com>
 * @todo 
 * Created: 2011-12-28
 */
class JSONInput extends CInputWidget
{

    public function init()
    {
        parent::init();
        if ($this->hasModel())
        {
            $attr = $this->attribute;
            CHtml::resolveName($this->model, $attr);
            $value = $this->model->$attr;
        }
        else
            $value = $this->value;
        
        if(is_array($value))
            $value = CJSON::encode ($value);
        elseif(!is_string($value) && $value!==null)
            throw new CException('JSONInput: Bad value type');
        $this->model->$attr = $value;
    }

    public function run()
    {
        echo CHtml::activeTextArea($this->model, $this->attribute);
    }

}

