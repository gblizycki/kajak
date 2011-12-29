<?php
$this->breadcrumbs=array(
	'Areas'=>array('index'),
	$model->id,
);

$this->menu=array(
	array('label'=>'Create Area', 'url'=>array('create')),
	array('label'=>'Update Area', 'url'=>array('update', 'id'=>$model->_id)),
	array('label'=>'Delete Area', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->_id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage Area', 'url'=>array('admin')),
);
?>

<h1>View Area #<?php echo $model->_id; ?></h1>
<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'points:raw',
		array(
                    'label'=>'createDate',
                    'value'=>$model->createDate->sec,
                    'type'=>'datetime',
                    ),
		array(
                    'label'=>'updateDate',
                    'value'=>$model->updateDate->sec,
                    'type'=>'datetime',
                    ),
		'info:raw',
		'style:raw',
	),
)); ?>