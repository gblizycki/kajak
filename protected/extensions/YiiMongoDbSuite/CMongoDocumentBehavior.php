<?php
class CMongoDocumentBehavior extends CBehavior
{
	public function events()
	{
		return array_merge(parent::events(), array(
			'onBeforeEmbeddedDocsInit'=>'beforeEmbeddedDocsInit',
			'onAfterEmbeddedDocsInit'=>'afterEmbeddedDocsInit',
			'onBeforeToArray'=>'beforeToArray',
			'onAfterToArray'=>'afterToArray',
                        'onBeforeSave'=>'beforeSave',
                        'onAfterSave'=>'afterSave',
		));
	}

	public function beforeEmbeddedDocsInit($event){}
	public function afterEmbeddedDocsInit($event){}
	public function beforeToArray($event){}
	public function afterToArray($event){}
	public function beforeSave($event){}
	public function afterSave($event){}
}
?>
