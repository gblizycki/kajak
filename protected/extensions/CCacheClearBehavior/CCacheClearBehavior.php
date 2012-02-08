<?php

class CCacheClearBehavior extends CMongoDocumentBehavior {
    public $cacheId = 'cache';
    
    public function afterSave($event)
    {
        Yii::app()->{$this->cacheId}->flush();
    }
}

?>