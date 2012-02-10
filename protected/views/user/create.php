<?php
$this->breadcrumbs=array(
	'Users'=>array('admin'),
	'Create',
);

$this->menu=array(
	array('label'=>'Manage User', 'url'=>array('admin')),
);
?>

<h1>Create User</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>