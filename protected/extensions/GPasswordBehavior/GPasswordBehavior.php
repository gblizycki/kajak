<?php

class GPasswordBehavior extends CActiveRecordBehavior
{

 public $passwordAttribute;
 public $saltAttribute;
 public $tempPasswordAttribute;
 public $passwordRenewalAttribute=null;
 
 public $oldPasswordAttribute;
 public $newPasswordAttribute;
 public $defaultLenght=8;
 /**
  * Responds to {@link CModel::onBeforeSave} event.
  * Generate password
  *
  * @param CModelEvent $event event parameter
  
 public function beforeValidate($event)
 {
  $owner=$this->owner;
  if ($owner->{$this->passwordAttribute} === null)
  {
   if($owner->{$this->tempPasswordAttribute}===null)
    $owner->{$this->tempPasswordAttribute}=$this->generatePassword($this->defaultLenght);
   $owner->{$this->saltAttribute} = $this->generateSalt($this->defaultLenght);
   $owner->{$this->passwordAttribute} = $this->hashPassword($owner->{$this->tempPasswordAttribute}, $owner->{$this->saltAttribute});
   if($this->passwordRenewalAttribute!=null)
    $owner->{$this->passwordRenewalAttribute} = new MongoDate;
  }
 }*/
 public function beforeSave($event)
 {
  $owner=$this->owner;
  if ($owner->{$this->passwordAttribute} === null)
  {
   if($owner->{$this->tempPasswordAttribute}===null)
    $owner->{$this->tempPasswordAttribute}=$this->generatePassword($this->defaultLenght);
   $owner->{$this->saltAttribute} = $this->generateSalt($this->defaultLenght);
   $owner->{$this->passwordAttribute} = $this->hashPassword($owner->{$this->tempPasswordAttribute}, $owner->{$this->saltAttribute});
   if($this->passwordRenewalAttribute!=null)
    $owner->{$this->passwordRenewalAttribute} = new MongoDate;
  }
 }
 /**
  * Generating password with given length. Password is strong with one
  * big letter ,one small and at least one digit.
  * @param int $length defualt:8
  * @return string
  */
 public function generatePassword($length)
 {
  $chars1 = 'abcdefghijkmnopqrstuvwxyz';
  $chars2 = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
  $chars3 = '1234567890';
  $password = '';
  for ($i = 0; $i < $length; $i++)
  {
   if ($i % 5 == 0)
    $password.= $chars3[mt_rand(0, strlen($chars3) - 1)];
   elseif ($i % 7 == 0)
    $password.= strtoupper($chars1[mt_rand(0, strlen($chars1) - 1)]);
   else
    $password.= $chars1[mt_rand(0, strlen($chars1) - 1)];
  }
  $password = str_shuffle($password);
  return $password;
 }

 /**
  * Genereting salt with given length. Same rules as password but at the
  * end string is attribute to md5 function.
  * @param int $length defualt:8
  * @return string
  */
 public function generateSalt($length)
 {
  return md5($this->generatePassword($length));
 }

 /**
  * Hashing password with user salt
  * @param string $password
  * @return string
  */
 public static function hashPassword($password,$salt)
 {
  return md5(md5($password) . md5($salt));
 }

 /**
   * Check password construction follow rules:
   * Password must be at least 8 characters and must contain at least one lower case letter, one upper case letter and one digit.
   * @param string $password
   * @return bool true if valid
   */
  public function validPassword($password)
  {
    if (!preg_match("/^.*(?=.{8,})(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).*$/", $password))
    {
      return false;
    }
    return true;
  }
  
  public function changePassword()
  {
   $oldPassword = $this->owner->{$this->oldPasswordAttribute};
   $newPassword = $this->owner->{$this->newPasswordAttribute};
   if($this->hashPassword($oldPassword, $this->owner->salt) === $this->owner->password)
   {
    $this->owner->password = $this->hashPassword($newPassword, $this->owner->salt);
    return true;
   }
   return false;
  }
}

?>
