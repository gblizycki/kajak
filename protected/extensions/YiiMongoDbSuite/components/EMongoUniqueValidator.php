<?php

/**
 * EMongoUniqueValidator.php
 *
 * PHP version 5.2+
 *
 * @author		Dariusz Górecki <darek.krk@gmail.com>
 * @author		Invenzzia Group, open-source division of CleverIT company http://www.invenzzia.org
 * @copyright	2011 CleverIT http://www.cleverit.com.pl
 * @license		http://www.yiiframework.com/license/ BSD license
 * @version		1.3
 * @category	ext
 * @package		ext.YiiMongoDbSuite
 * @since		v1.1
 */

/**
 * @since v1.1
 */
class EMongoUniqueValidator extends CValidator
{

 public $allowEmpty = true;
 public $model = null;
 public $type = null;

 public function validateAttribute($object, $attribute)
 {
  $value = $object->{$attribute};
  if ($this->allowEmpty && ($value === null || $value === ''))
   return;

  if ($this->type !== null)
  {
   switch ($this->type)
   {
    case 'MongoId':if (!$value instanceof MongoId)
      $value = new MongoId($value);break;
    case 'MongoDate':if (!$value instanceof MongoDate)
      $value = new MongoDate($value);break;
    case 'GeoPoint':$value = array((double) $value[0], (double) $value[1]);
     break;
    default:if ($value !== null)
      settype($value, $this->type);break;
   }
  }
  $criteria = new EMongoCriteria;
  $criteria->{$attribute} = $value;
  if ($this->model === null)
   $count = $object->model()->count($criteria);
  else
   $count = EMongoDocument::model($this->model)->model()->count($criteria);

  if ($count !== 0)
   $this->addError(
           $object, $attribute, Yii::t('yii', '{attribute} is not unique in DB.')
   );
 }

}