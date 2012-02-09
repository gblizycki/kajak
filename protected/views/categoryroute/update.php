<?php
$this->breadcrumbs=array(
	'Category Routes'=>array('index'),
	$model->name=>array('view','id'=>$model->_id),
	'Update',
);

$this->menu=array(
	array('label'=>'Create CategoryRoute', 'url'=>array('create')),
	array('label'=>'View CategoryRoute', 'url'=>array('view', 'id'=>$model->_id)),
	array('label'=>'Manage CategoryRoute', 'url'=>array('admin')),
);
?>

<h1>Update CategoryRoute <?php echo $model->_id; ?></h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>