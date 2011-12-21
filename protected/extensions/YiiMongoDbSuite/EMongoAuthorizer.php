<?php

class EMongoAuthorizer extends RAuthorizer
{
 	/**
	 * @property RDbAuthManager the authorization manager.
	 */
	private $_authManager;
    /**
	* Initializes the authorizer.
	*/
	public function init()
	{
		parent::init();
		$this->_authManager = Yii::app()->getAuthManager();
	}
   /**
	* Returns the users with superuser privileges.
	* @return the superusers.
	*/
	public function getSuperusers()
	{
		$assignments = $this->_authManager->getAssignmentsByItemName( Rights::module()->superuserName );

		$userIdList = array();
		foreach( $assignments as $userId=>$assignment )
			$userIdList[] = new MongoId($userId);

		//$criteria = new CDbCriteria();
		//$criteria->addInCondition(Rights::module()->userIdColumn, $userIdList);
        $criteria = new EMongoCriteria();
        $criteria->{Rights::module()->userIdColumn}('in',$userIdList);
		$userClass = Rights::module()->userClass;
		//$users = CActiveRecord::model($userClass)->findAll($criteria);
        $users = EMongoDocument::model($userClass)->findAll($criteria);
		$users = $this->attachUserBehavior($users);

		$superusers = array();
		foreach( $users as $user )
			$superusers[] = $user->email;

		// Make sure that we have superusers, otherwise we would allow full access to Rights
		// if there for some reason is not any superusers.
		if( $superusers===array() )
			throw new CHttpException(403, Rights::t('core', 'There must be at least one superuser!'));

		return $superusers;
	}
}
?>
