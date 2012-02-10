<?php
$this->breadcrumbs=array(
	'Areas'=>array('admin'),
	$model->id=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>'Create Area', 'url'=>array('create')),
	array('label'=>'View Area', 'url'=>array('view', 'id'=>$model->_id)),
	array('label'=>'Manage Area', 'url'=>array('admin')),
);
?>

<h1>Update Area <?php echo $model->_id; ?></h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>