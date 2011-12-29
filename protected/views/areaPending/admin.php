<?php
$this->breadcrumbs=array(
	'Area Pendings'=>array('index'),
	'Manage',
);

$this->menu=array(
	array('label'=>'List AreaPending', 'url'=>array('index')),
	array('label'=>'Create AreaPending', 'url'=>array('create')),
);

?>

<h1>Manage Area Pendings</h1>

<p>
You may optionally enter a comparison operator (<b>&lt;</b>, <b>&lt;=</b>, <b>&gt;</b>, <b>&gt;=</b>, <b>&lt;&gt;</b>
or <b>=</b>) at the beginning of each of your search values to specify how the comparison should be done.
</p>

<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'area-pending-grid',
	'dataProvider'=>$model->search(), 
	'filter'=>$model,
	'columns'=>array(
		'points',
		'createDate',
		'updateDate',
		'objectId',
		'_id',
		/*
                'info',
		'style',
		*/
		array(
			'class'=>'CButtonColumn',
		),
	),
)); ?>