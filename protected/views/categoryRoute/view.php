<?php
$this->breadcrumbs=array(
	'Category Routes'=>array('index'),
	$model->name,
);

$this->menu=array(
	array('label'=>'Create CategoryRoute', 'url'=>array('create')),
	array('label'=>'Update CategoryRoute', 'url'=>array('update', 'id'=>$model->_id)),
	array('label'=>'Delete CategoryRoute', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->_id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage CategoryRoute', 'url'=>array('admin')),
);
?>

<h1>View CategoryRoute #<?php echo $model->_id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'name',
		'description',
		'title',
		'filters',
		'_id',
		'style',
	),
)); ?>