<?php
$this->breadcrumbs=array(
	'Places'=>array('admin'),
	$model->id=>array('view','id'=>$model->_id),
	'Update',
);

$this->menu=array(
	array('label'=>'Create Place', 'url'=>array('create')),
	array('label'=>'View Place', 'url'=>array('view', 'id'=>$model->_id)),
	array('label'=>'Manage Place', 'url'=>array('admin')),
);
?>

<h1>Update Place <?php echo $model->_id; ?></h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>