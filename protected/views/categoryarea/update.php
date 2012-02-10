<?php
$this->breadcrumbs=array(
	'Category Areas'=>array('admin'),
	$model->name=>array('view','id'=>$model->_id),
	'Update',
);

$this->menu=array(
	array('label'=>'Create CategoryArea', 'url'=>array('create')),
	array('label'=>'View CategoryArea', 'url'=>array('view', 'id'=>$model->_id)),
	array('label'=>'Manage CategoryArea', 'url'=>array('admin')),
);
?>

<h1>Update CategoryArea <?php echo $model->_id; ?></h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>