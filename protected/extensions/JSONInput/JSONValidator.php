<?php

/**
 * Description of JSONValidator
 *
 * @name JSONValidator
 * @author Grzegorz Bliżycki <grzegorzblizycki@gmail.com>
 * @todo 
 * Created: 2011-12-28
 */
class JSONValidator extends CValidator
{

    /**
     * Validates the attribute of the object.
     * If there is any error, the error message is added to the object.
     * @param CModel $object the object being validated
     * @param string $attribute the attribute being validated
     */
    protected function validateAttribute($object, $attribute)
    {
        // extract the attribute value from it's model objec
        $value = $object->$attribute;
        if($value===null)
            return;
        if(is_string($value) && strlen($value)==0)
            $value = array();
        if (is_string($value))
        {
            $value[0]='{';
            $value[strlen($value)-1]='}';
            $value = CJSON::decode($value);
        }
        if (!is_array($value))
            $this->addError($object, $attribute, 'Bad attribute format');
        else
            $object->$attribute = $value;
    }

}

