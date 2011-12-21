<?php

/**
 * User model for colletion user
 * 
 * @author Grzegorz Blizycki <grzegorzblizycki@gmail.com>
 * @package models
 * @category user
 * 
 * @property-read string generatedPassword
 * @property-read Document[] documentOwned
 * @property-read Image[] imageOwned
 * @property-read Location[] location
 */
class User extends CMongoDocument
{
 //User types
 const USER_UNREGISTER = 0;
 const USER_CUSTOMER = 1;
 const USER_WORKER = 2;
 const USER_SHOPKEEPER = 3;
 const USER_ADMIN = 4;

 /**
  * @var string Email
  */
 public $email;

 /**
  * @var string Encoded password
  */
 public $password;

 /**
  * @var string Password salt
  */
 public $salt;

 /**
  * @var string Name - with surname
  */
 public $name;

 /**
  * @var string Date of birth
  */
 public $birthday;

 /**
  * @var string Notes
  */
 public $note;

 /**
  * @var int User type 
  */
 public $type;

 /**
  * User preferences, array of arrays [ [name,value],...]
  * @var array 
  */
 public $preferences;

 /**
  * @var MongoDate Create timestamp
  */
 public $createDate;

 /**
  * @var MongoDate Update timestamp
  */
 public $updateDate;
 /**
  *
  * @var string Temporary generated password in decoded form
  */
 private $_generatedPassword = null; //temp password only on creating new 
 private $_newPassword;
 private $_oldPassword;
 private $_newPasswordAgain;

 /**
  * Returns the static model of the specified AR class.
  * @return UserRights the static model class
  */
 public static function model($className=__CLASS__)
 {
  return parent::model($className);
 }

 /**
  * Return appropriate model based on user type
  * @param array $attributes
  * @return User
  */
 protected function instantiate($attributes)
 {
  switch ($attributes['type'])
  {
   case self::USER_UNREGISTER: $model = new User(null);
    break;
   case self::USER_CUSTOMER: $model = new Customer(null);
    break;
   case self::USER_WORKER: $model = new Worker(null);
    break;
   case self::USER_SHOPKEEPER: $model = new Shopkeeper(null);
    break;
   case self::USER_ADMIN: $model = new Admin(null);
    break;
   default :throw new CException('Unkown type of user');
  }
  $model->initEmbeddedDocuments(); // We have to do it manually here!
  $model->setAttributes($attributes, false);
  return $model;
 }

 /**
  * @return string the associated collection name
  */
 public function getCollectionName()
 {
  return 'user';
 }

 /**
  * @return array validation rules for model attributes.
  */
 public function rules()
 {
  return array(
      array('newPassword', 'ext.GPasswordBehavior.GPasswordValidator'),
      array('oldPassword', 'ext.GPasswordBehavior.GOldPasswordValidator', 'oldPassword' => $this->password, 'salt' => $this->salt),
      array('newPasswordAgain', 'compare', 'compareAttribute' => 'newPassword', 'strict' => true),
      array('birthday,email,name,oldPassword', 'safe'),
      array('email, password, salt, name, surname, birthday, note, type, passwordRenewal, updateDate', 'safe', 'on' => 'search'),
  );
 }

 /**
  * @return array customized attribute labels (name=>label)
  */
 public function attributeLabels()
 {
  return array(
      'id' => 'ID',
      'email' => 'Email',
      'password' => 'Password',
      'salt' => 'Salt',
      'name' => 'Name',
      'surname' => 'Surname',
      'birthday' => 'Birthday',
      'note' => 'Note',
      'type' => 'Type',
      'passwordRenewal' => 'Password Renewal',
      'updateDate' => 'Update Date',
      'createDate' => 'Create Date',
  );
 }

 /**
  * returns array of behaviors
  * @return array
  */
 public function behaviors()
 {
  return array(
      'CTimestampBehavior' => array(
          'class' => 'zii.behaviors.CTimestampBehavior',
          'createAttribute' => 'createDate',
          'updateAttribute' => 'updateDate',
          'setUpdateOnCreate' => true,
          'timestampExpression' => 'new MongoDate()'
      ),
      'GPasswordBehavior' => array(
          'class' => 'ext.GPasswordBehavior.GPasswordBehavior',
          'passwordAttribute' => 'password',
          'saltAttribute' => 'salt',
          'tempPasswordAttribute' => 'generatedPassword',
          'oldPasswordAttribute' => 'oldPassword',
          'newPasswordAttribute' => 'newPassword',
      ),
  );
 }

 /**
  * returns array of indexes
  * @return array
  */
 public function indexes()
 {
  return array(
      // index name is not important, you may write whatever you want, just must be unique
      'emailIndex' => array(
          // key array holds list of fields for index
          // you may define multiple keys for index and multikey indexes
          // each key must have a sorting direction SORT_ASC or SORT_DESC
          'key' => array(
              'email' => EMongoCriteria::SORT_ASC,
          ),
          // unique, if indexed field must be unique, define a unique key
          'unique' => true,
      ),
  );
 }

 /**
  * Generated password getter
  * @return string
  */
 public function getGeneratedPassword()
 {
  return $this->_generatedPassword;
 }

 /**
  * Generated password setter
  * @return string
  */
 public function setGeneratedPassword($value)
 {
  $this->_generatedPassword = (string) $value;
 }


 /**
  * Assign rights after save
  */
 public function afterSave()
 {
  parent::afterSave();
  switch ($this->type)
  {
   case self::USER_CUSTOMER: Rights::assign('Customer', $this->id);
    break;
   case self::USER_WORKER: Rights::assign('Worker', $this->id);
    break;
   case self::USER_SHOPKEEPER: Rights::assign('Shopkeeper', $this->id);
    break;
   case self::USER_ADMIN: Rights::assign('Admin', $this->id);
    break;
   default :throw new CException('Unkown type of user');
  }
 }

 /**
  * Revoke assigned rights before delte
  * @return bool
  */
 public function beforeDelete()
 {
  parent::beforeDelete();
  $roles = Rights::getAssignedRoles($this->id);
  foreach ($roles as $role)
  {
   if (!Rights::revoke($role->name, $this->id))
    return false;
  }
  return true;
 }

 /**
  * Return shor email with ****
  * @return string 
  */
 public function getShortEmail()
 {
  return $this->email[0] . $this->email[1] . '...' . substr($this->email, strpos($this->email, '@') - 1);
 }

 /**
  * Return birthday without year
  * @return string
  */
 public function getShortBirthday()
 {
  return substr($this->birthday, 5);
 }

 public function getNewPassword()
 {
  return $this->_newPassword;
 }

 public function setNewPassword($value)
 {
  $this->_newPassword = $value;
 }

 public function getNewPasswordAgain()
 {
  return $this->_newPasswordAgain;
 }

 public function setNewPasswordAgain($value)
 {
  $this->_newPasswordAgain = $value;
 }

 public function getOldPassword()
 {
  return $this->_oldPassword;
 }

 public function setOldPassword($value)
 {
  $this->_oldPassword = $value;
 }

}

?>
