<?php
$this->breadcrumbs=array(
	'Areas'=>array('admin'),
	'Create',
);

$this->menu=array(
	array('label'=>'Manage Area', 'url'=>array('admin')),
);
?>

<h1>Create Area</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>