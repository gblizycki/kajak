<?php

class EWebUser extends RWebUser
{
    public $logoutUrl = array('site/logout');
    private $_model = null;
    private function loadUser($id=null)
    {

        if ($this->_model == null)
        {
            if ($id != null)
            {
                $this->_model = EMongoDocument::model(Yii::app()->getModule('rights')->userClass)->findByPk($id);
            }
                
        }
        return $this->_model;
    }

    public function getModel()
    {
        return $this->loadUser(Yii::app()->user->id);
    }
    public function login($identity, $duration = 0)
    {
        parent::login($identity, $duration);
        
    }
    
    public function getRoles()
    {
        if($this->id!==null)
            return Rights::getAssignedRoles($this->getId());
        return array();
    }
    public function hasRole($roleName)
    {
        $roles = $this->roles;
        if(is_array($roleName))
        {
            $value = true;
            foreach($roleName as $name)
            {
                $value = $value && array_key_exists($name, $roles);
            }
            return (bool)$value;
        }
        return array_key_exists($roleName, $roles);
    }
    public function hasAnyRole($roleName)
    {
        $roles = $this->roles;
        if(is_array($roleName))
        {
            $value = false;
            foreach($roleName as $name)
            {
                $value = $value || array_key_exists($name, $roles);
            }
            return (bool)$value;
        }
        return array_key_exists($roleName, $roles);
    }
    
    public function afterLogin($fromCookie) {
        $cookie = new CHttpCookie('DEMap-username', CJSON::encode(
                array(
                    'username'=>  $this->getName(),
                    'roles'=>Rights::getAssignedRoles($this->id),
                )
                ));
        $cookie->expire = time()+3600;
        Yii::app()->request->cookies['DEMap-username'] = $cookie;
        
        parent::afterLogin($fromCookie);
    }
    public function afterLogout() {
        unset(Yii::app()->request->cookies['DEMap-username']);
        parent::afterLogout();
    }

}

?>
