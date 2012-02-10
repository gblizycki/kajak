<?php
$this->breadcrumbs=array(
	'Routes'=>array('admin'),
	'Create',
);

$this->menu=array(
	array('label'=>'Manage Route', 'url'=>array('admin')),
);
?>

<h1>Create Route</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>