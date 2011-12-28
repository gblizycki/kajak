<?php

class CMongoTypeBehavior extends EMongoDocumentBehavior
{

    public $attributes = array();

    public function beforeToArray($event)
    {
        parent::beforeToArray($event);
        foreach ($this->attributes as $atr => $type)
        {
            $this->owner->{$atr} = $this->setType($this->owner->{$atr}, $type);
        }
    }

    private function setType($value, $type)
    {
        if (strpos($type, 'array.'))
        {
            $type = str_replace('array.', '', $type);
            foreach ($value as $k => $v)
            {
                $value[$k] = $this->setType($v, $type);
            }
            return $value;
        }
        switch ($type)
        {
            case 'MongoId':if (!$value instanceof MongoId)
                    $value = new MongoId($value);break;
            case 'MongoDate':if (!$value instanceof MongoDate)
                    $value = ($value instanceof int) ? new MongoDate($value) : new MongoDate(strtotime($value));break;
            case 'GeoPoint':$value = array((double) $value[0], (double) $value[1]);
                break;
            default:if ($value !== null)
            {
                if((is_array($value) && $type=='array') || strlen(trim($value)) != 0)
                    settype($value, $type);
            }
                else
                    $value = null;
                break;
        }
        return $value;
    }

}

?>