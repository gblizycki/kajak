<?php
$this->breadcrumbs=array(
	'Place Pendings'=>array('admin'),
	'Manage',
);

$this->menu=array(
	array('label'=>'Create PlacePending', 'url'=>array('create')),
);

?>

<h1>Manage Place Pendings</h1>

<p>
You may optionally enter a comparison operator (<b>&lt;</b>, <b>&lt;=</b>, <b>&gt;</b>, <b>&gt;=</b>, <b>&lt;&gt;</b>
or <b>=</b>) at the beginning of each of your search values to specify how the comparison should be done.
</p>

<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'place-pending-grid',
	'dataProvider'=>$model->search(), 
	'filter'=>$model,
	'columns'=>array(
		'address',
		'authorId',
		'type',
		'category',
		'objectId',
		'_id',
		/*
		'info',
		'style',
		'location',
		*/
		array(
			'class'=>'CButtonColumn',
		),
	),
)); ?>