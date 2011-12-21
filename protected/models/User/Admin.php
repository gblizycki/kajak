<?php

/**
 * Admin model for colletion user
 * 
 * @author Grzegorz Blizycki <grzegorzblizycki@gmail.com>
 * @package models
 * @category user
 */
class Admin extends User
{
 /**
  * Returns the static model of the specified AR class.
  * @return UserRights the static model class
  */
 public static function model($className=__CLASS__)
 {
  return parent::model($className);
 }
 /**
  * Set default type to USER_ADMIN
  */
 public function afterConstruct()
 {
  //parent::afterConstruct();
  if ($this->type == null)
   $this->type = self::USER_ADMIN;
 }

 /**
  * Set default type to USER_ADMIN
  */
 public function defaultScope()
 {
  return array(
      'conditions' => array(
          'type' => array('=='=>self::USER_ADMIN),
      ),
  );
 }
 
 /**
  * Return default url after login
  * @return string
  */
 public function getDefaultUrl()
 {
  return CHtml::normalizeUrl(array('site/index'));
 }
 

}

?>
