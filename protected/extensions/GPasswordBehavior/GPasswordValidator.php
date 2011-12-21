<?php

class GPasswordValidator extends CValidator
{
 public $allowEmpty = false;
 public function validateAttribute($object, $attribute)
 {
  $value = $object->{$attribute};
  if ($this->allowEmpty && ($value === null || $value === ''))
   return;
  if (!preg_match("/^.*(?=.{8,})(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).*$/", $value))
      $this->addError($object, $attribute, Yii::t('yii', '{attribute} must be valid password.'));
 }
}
?>
