<?php
$this->breadcrumbs=array(
	'Category Places'=>array('index'),
	$model->name=>array('view','id'=>$model->_id),
	'Update',
);

$this->menu=array(
	array('label'=>'Create CategoryPlace', 'url'=>array('create')),
	array('label'=>'View CategoryPlace', 'url'=>array('view', 'id'=>$model->_id)),
	array('label'=>'Manage CategoryPlace', 'url'=>array('admin')),
);
?>

<h1>Update CategoryPlace <?php echo $model->_id; ?></h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>