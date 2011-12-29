<?php
$this->breadcrumbs=array(
	'Area Pendings'=>array('index'),
	$model->id,
);

$this->menu=array(
	array('label'=>'List AreaPending', 'url'=>array('index')),
	array('label'=>'Create AreaPending', 'url'=>array('create')),
	array('label'=>'Update AreaPending', 'url'=>array('update', 'id'=>$model->_id)),
	array('label'=>'Delete AreaPending', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->_id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage AreaPending', 'url'=>array('admin')),
);
?>

<h1>View AreaPending #<?php echo $model->_id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		//'points',
		'createDate',
		'updateDate',
		'objectId',
		'_id',
		//'info',
		//'style',
	),
)); ?>