<?php

class GOldPasswordValidator extends CValidator
{
 public $allowEmpty = false;
 public $oldPassword;
 public $salt;
 public function validateAttribute($object, $attribute)
 {
  $value = $object->{$attribute};
  if ($this->allowEmpty && ($value === null || $value === ''))
   return;
  if(!GPasswordBehavior::hashPassword($value, $this->salt)===$this->oldPassword)
      $this->addError($object, $attribute, Yii::t('yii', '{attribute} is not correct actual password.'));
 }
}
?>
