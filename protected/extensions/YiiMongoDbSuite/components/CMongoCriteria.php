<?php

class CMongoCriteria extends EMongoCriteria
{
    const INDEX_2D = '2d';
 /**
  * Add condidtion based on model value
  * @param type $column
  * @param type $value
  * @param type $partialMatch
  * @param type $operator
  * @param type $escape
  * @return CMongoCriteria 
  */
 public function compare($column, $value,$type="string",$partialMatch=false)
 {
  if (is_array($value))
  {
   //if ($value === array())
    //return $this;
      foreach($value as &$v)
      {
          $v = $this->setType($v, $type);
      }
   return $this->addCond($column,'in', $value);//$this->addInCondition($column, $value, $operator);
  }
  else
   $value = "$value";

  if($value===null)
   return $this;
  if (preg_match('/^(?:\s*(<>|<=|>=|<|>|=))?(.*)$/', $value, $matches))
  {
   $value = $matches[2];
   $op = $matches[1];
  }
  else
   $op = '';

  if ($value === '')
   return $this;

  if($type==='MongoId')
   $value = new MongoId($value);
  elseif($type === 'MongoDate')
   $value = new MongoDate(strtotime ($value));
   else settype($value,$type);
  if ($partialMatch)
  {
   if ($op === '')
   {
    $this->{$column} = new MongoRegex('/.*'.$value.'.*/i');
    return $this;
   }
   if ($op === '<>')
   {
    //@todo add negative criteria
    $this->{$column} = new MongoRegex('//i');
    return $this;
   }
    
  }
  else if ($op === '' && $type==='MongoDate')
   $op= '>';
   elseif($op==='')
   $op = '==';
  
  $this->addCond($column, $op, $value);

  return $this;
 }

 protected function setType($value,$type)
 {
   switch($type)
   {
    case 'MongoId':if(!$value instanceof MongoId)$value=new MongoId($value);break;
    case 'MongoDate':if(!$value instanceof MongoDate)$value = ($value instanceof int)?new MongoDate($value):new MongoDate(strtotime($value));break;
    case 'GeoPoint':$value=array((double)$owner->{$atr}[0],(double)$owner->{$atr}[1]);break;
    default:if($value !==null && strlen(trim($value))!=0)
     settype($value,$type);
    else
     $value = null;
    break;
   }
   return $value;
 }
 
}

?>
