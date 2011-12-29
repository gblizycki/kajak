<?php
$this->breadcrumbs=array(
	'Routes'=>array('index'),
	$model->id=>array('view','id'=>$model->_id),
	'Update',
);

$this->menu=array(
	array('label'=>'List Route', 'url'=>array('index')),
	array('label'=>'Create Route', 'url'=>array('create')),
	array('label'=>'View Route', 'url'=>array('view', 'id'=>$model->_id)),
	array('label'=>'Manage Route', 'url'=>array('admin')),
);
?>

<h1>Update Route <?php echo $model->_id; ?></h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>