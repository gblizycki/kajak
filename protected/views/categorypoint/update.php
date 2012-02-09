<?php
$this->breadcrumbs=array(
	'Category Points'=>array('index'),
	$model->name=>array('view','id'=>$model->_id),
	'Update',
);

$this->menu=array(
	array('label'=>'Create CategoryPoint', 'url'=>array('create')),
	array('label'=>'View CategoryPoint', 'url'=>array('view', 'id'=>$model->_id)),
	array('label'=>'Manage CategoryPoint', 'url'=>array('admin')),
);
?>

<h1>Update CategoryPoint <?php echo $model->_id; ?></h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>