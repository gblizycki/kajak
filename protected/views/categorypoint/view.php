<?php
$this->breadcrumbs=array(
	'Category Points'=>array('admin'),
	$model->name,
);

$this->menu=array(
	array('label'=>'Create CategoryPoint', 'url'=>array('create')),
	array('label'=>'Update CategoryPoint', 'url'=>array('update', 'id'=>$model->_id)),
	array('label'=>'Delete CategoryPoint', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->_id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage CategoryPoint', 'url'=>array('admin')),
);
?>

<h1>View CategoryPoint #<?php echo $model->_id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'name',
		'description',
		'title',
		'_id',
	),
)); ?>