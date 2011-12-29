<?php
$this->breadcrumbs=array(
	'Route Pendings'=>array('index'),
	$model->id,
);

$this->menu=array(
	array('label'=>'List RoutePending', 'url'=>array('index')),
	array('label'=>'Create RoutePending', 'url'=>array('create')),
	array('label'=>'Update RoutePending', 'url'=>array('update', 'id'=>$model->_id)),
	array('label'=>'Delete RoutePending', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->_id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage RoutePending', 'url'=>array('admin')),
);
?>

<h1>View RoutePending #<?php echo $model->_id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'authorId',
		'category',
		'points',
		'objectId',
		'_id',
		//'info',
		//'style',
	),
)); ?>