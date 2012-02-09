<?php
$this->breadcrumbs=array(
	'Place Pendings'=>array('index'),
	$model->_id,
);

$this->menu=array(
	array('label'=>'Create PlacePending', 'url'=>array('create')),
	array('label'=>'Update PlacePending', 'url'=>array('update', 'id'=>$model->_id)),
	array('label'=>'Delete PlacePending', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->_id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage PlacePending', 'url'=>array('admin')),
);
?>

<h1>View PlacePending #<?php echo $model->_id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'address',
		'authorId',
		'type',
		'category',
		'objectId',
		'_id',
		//'info',
		//'style',
		//'location',
	),
)); ?>