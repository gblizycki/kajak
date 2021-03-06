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
class User extends CMongoDocument {
    //User types

    const USER_UNREGISTER = 0;
    const USER_ADMIN = 1;
    const USER_MODERATOR = 2;
    const USER_REGISTER = 3;

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
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    /**
     * Return appropriate model based on user type
     * @param array $attributes
     * @return User
     */
    protected function instantiate($attributes) {
        switch ($attributes['type']) {
            case self::USER_UNREGISTER: $model = new User(null);
                break;
            case self::USER_ADMIN: $model = new Admin(null);
                break;
            case self::USER_MODERATOR: $model = new Moderator(null);
                break;
            case self::USER_REGISTER: $model = new User(null);
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
    public function getCollectionName() {
        return 'user';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        return array(
            //array('newPassword', 'ext.GPasswordBehavior.GPasswordValidator'),
            //array('oldPassword', 'ext.GPasswordBehavior.GOldPasswordValidator', 'oldPassword' => $this->password, 'salt' => $this->salt),
            //array('newPasswordAgain', 'compare', 'compareAttribute' => 'newPassword', 'strict' => true),
            array('birthday,email,name,type,note', 'safe'),
            array('email, password, salt, name, surname, birthday, note, type, passwordRenewal, updateDate', 'safe', 'on' => 'search'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
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
    public function behaviors() {
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
            'MongoTypes' => array(
                'class' => 'CMongoTypeBehavior',
                'attributes' => array(
                    'createDate' => 'MongoDate',
                    'updateDate' => 'MongoDate',
                    'email' => 'string',
                    'birthday'=>'string',
                    'name'=>'string',
                    'type'=>'int',
                    'password'=>'string',
                    'salt'=>'string'
                ),
            ),
        );
    }

    /**
     * returns array of indexes
     * @return array
     */
    public function indexes() {
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
    public function getGeneratedPassword() {
        return $this->_generatedPassword;
    }

    /**
     * Generated password setter
     * @return string
     */
    public function setGeneratedPassword($value) {
        $this->_generatedPassword = (string) $value;
    }

    /**
     * Assign rights after save
     */
    public function afterSave() {
        parent::afterSave();
            switch ($this->type) {
                case self::USER_UNREGISTER: Rights::assign('UserUnregister', $this->id);
                    break;
                case self::USER_ADMIN: Rights::assign('Admin', $this->id);
                    break;
                case self::USER_MODERATOR: Rights::assign('Moderator', $this->id);
                    break;
                case self::USER_REGISTER: Rights::assign('UserRegister', $this->id);
                    break;
                default :throw new CException('Unkown type of user');
            }
    }

    /**
     * Revoke assigned rights before delte
     * @return bool
     */
    public function beforeDelete() {
        $roles = Rights::getAssignedRoles($this->id);
        foreach ($roles as $role) {
            if (!Rights::revoke($role->name, $this->id))
                return false;
        }
        return true;
    }

    /**
     * Return shor email with ****
     * @return string 
     */
    public function getShortEmail() {
        return $this->email[0] . $this->email[1] . '...' . substr($this->email, strpos($this->email, '@') - 1);
    }

    /**
     * Return birthday without year
     * @return string
     */
    public function getShortBirthday() {
        return substr($this->birthday, 5);
    }

    public function getNewPassword() {
        return $this->_newPassword;
    }

    public function setNewPassword($value) {
        $this->_newPassword = $value;
    }

    public function getNewPasswordAgain() {
        return $this->_newPasswordAgain;
    }

    public function setNewPasswordAgain($value) {
        $this->_newPasswordAgain = $value;
    }

    public function getOldPassword() {
        return $this->_oldPassword;
    }

    public function setOldPassword($value) {
        $this->_oldPassword = $value;
    }

    /**
     * Simple search by attributes
     * @param array $pagination
     * @return CMongoDocumentDataProvider 
     */
    public function search($pagination = array()) {
        $criteria = new CMongoCriteria();
        $criteria->compare('_id', $this->_id, 'MongoId', true);
        $criteria->compare('email', $this->email, 'string', true);
        $criteria->compare('name', $this->name, 'string', true);
        $criteria->compare('birthday', $this->birthday, 'string', true);
        $criteria->compare('note', $this->note, 'string', true);
        $criteria->compare('type', $this->type, 'int');
        $criteria->compare('createDate', $this->createDate, 'MongoDate', true);
        $criteria->compare('updateDate', $this->updateDate, 'MongoDate', true);
        $sort = new CSort();
        $sort->attributes = array(
            'defaultOrder' => '_id DESC',
            '_id',
            'email',
            'name',
            'birthday',
            'note',
            'type',
            'createDate',
            'updateDate',
        );
        return new CMongoDocumentDataProvider(get_class($this), array(
                    'criteria' => $criteria,
                    'sort' => $sort,
                    'pagination' => $pagination,
                ));
    }

}

?>
