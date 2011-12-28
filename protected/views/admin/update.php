<?php
$this->breadcrumbs=array(
	'Admins'=>array('index'),
	$model->name=>array('view','id'=>$model->_id),
	'Update',
);

$this->menu=array(
	array('label'=>'List Admin', 'url'=>array('index')),
	array('label'=>'Create Admin', 'url'=>array('create')),
	array('label'=>'View Admin', 'url'=>array('view', 'id'=>$model->_id)),
	array('label'=>'Manage Admin', 'url'=>array('admin')),
);
?>

<h1>Update Admin <?php echo $model->_id; ?></h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>