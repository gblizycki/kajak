<?php
$this->breadcrumbs=array(
	'Category Areas'=>array('admin'),
	$model->name,
);

$this->menu=array(
	array('label'=>'Create CategoryArea', 'url'=>array('create')),
	array('label'=>'Update CategoryArea', 'url'=>array('update', 'id'=>$model->_id)),
	array('label'=>'Delete CategoryArea', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->_id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage CategoryArea', 'url'=>array('admin')),
);
?>

<h1>View CategoryArea #<?php echo $model->_id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'name',
		'description',
		'title',
		'_id',
	),
)); ?>