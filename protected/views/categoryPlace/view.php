<?php
$this->breadcrumbs=array(
	'Category Places'=>array('index'),
	$model->name,
);

$this->menu=array(
	array('label'=>'List CategoryPlace', 'url'=>array('index')),
	array('label'=>'Create CategoryPlace', 'url'=>array('create')),
	array('label'=>'Update CategoryPlace', 'url'=>array('update', 'id'=>$model->_id)),
	array('label'=>'Delete CategoryPlace', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->_id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage CategoryPlace', 'url'=>array('admin')),
);
?>

<h1>View CategoryPlace #<?php echo $model->_id; ?></h1>

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