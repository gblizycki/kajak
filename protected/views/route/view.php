<?php
$this->breadcrumbs=array(
	'Routes'=>array('admin'),
	$model->id,
);

$this->menu=array(
	array('label'=>'Create Route', 'url'=>array('create')),
	array('label'=>'Update Route', 'url'=>array('update', 'id'=>$model->_id)),
	array('label'=>'Delete Route', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->_id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage Route', 'url'=>array('admin')),
);
?>

<h1>View Route #<?php echo $model->_id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'authorId',
		'category',
		//'points',
		'_id',
		//'info',
		//'style',
	),
)); ?>