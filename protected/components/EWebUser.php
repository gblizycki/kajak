<?php

class EWebUser extends RWebUser
{

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

}

?>
