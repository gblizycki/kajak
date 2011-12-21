<?php

/**
 * UserIdentity represents the data needed to identity a user.
 * It contains the authentication method that checks if the provided
 * data can identity the user.
 */
class UserIdentity extends CUserIdentity
{
	private $_id;
	/**
	 * Authenticates a user.
	 * @return boolean whether authentication succeeds.
	 */
	public function authenticate()
	{
        $criteria = new EMongoCriteria();
        $criteria->email('==',strtolower($this->username));
		$user=User::model()->find($criteria);//findAll(array('conditions'=>array('email'=>array('==',strtolower($this->username)))));//User::model()->find('LOWER(username)=?',array(strtolower($this->username)));
                
		if($user===null)
			$this->errorCode=self::ERROR_USERNAME_INVALID;
		else if($user->password !== $user->hashPassword($this->password,$user->salt))
			$this->errorCode=self::ERROR_PASSWORD_INVALID;
		else
		{
			$this->_id=$user->_id;
			$this->username=$user->email;
			$this->errorCode=self::ERROR_NONE;
		}
		return $this->errorCode==self::ERROR_NONE;
	}

	/**
	 * @return integer the ID of the user record
	 */
	public function getId()
	{
		return $this->_id;
	}
}