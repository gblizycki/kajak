<?php
class CMongoTypeBehavior extends EMongoDocumentBehavior
{
 public $attributes=array();
 public function beforeToArray($event)
 {
  parent::beforeToArray($event);
  $owner = $this->owner;
  foreach($this->attributes as $atr=>$type)
  {
   switch($type)
   {
    case 'MongoId':if(!$owner->$atr instanceof MongoId)$owner->$atr=new MongoId($owner->$atr);break;
    case 'MongoDate':if(!$owner->$atr instanceof MongoDate)$owner->$atr = ($owner->$atr instanceof int)?new MongoDate($owner->$atr):new MongoDate(strtotime($owner->$atr));break;
    case 'GeoPoint':$owner->$atr=array((double)$owner->{$atr}[0],(double)$owner->{$atr}[1]);break;
    default:if($owner->$atr !==null && strlen(trim($owner->$atr))!=0)
     settype($owner->$atr,$type);
    else
     $owner->$atr = null;
    break;
   }
  }
 }
}
?>