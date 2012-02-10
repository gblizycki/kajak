<?php
$this->breadcrumbs=array(
	'Data Sources'=>array('admin'),
	$model->_id,
);

$this->menu=array(
	array('label'=>'Create DataSource', 'url'=>array('create')),
	array('label'=>'Update DataSource', 'url'=>array('update', 'id'=>$model->_id)),
	array('label'=>'Delete DataSource', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->_id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage DataSource', 'url'=>array('admin')),
);
?>

<h1>View DataSource #<?php echo $model->_id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'format',
		'version',
                'pending:boolean',
		//'options',
		'_id',
	),
)); ?>