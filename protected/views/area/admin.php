<?php
$this->breadcrumbs=array(
	'Areas'=>array('index'),
	'Manage',
);

$this->menu=array(
	array('label'=>'Create Area', 'url'=>array('create')),
);
?>

<h1>Manage Areas</h1>

<p>
You may optionally enter a comparison operator (<b>&lt;</b>, <b>&lt;=</b>, <b>&gt;</b>, <b>&gt;=</b>, <b>&lt;&gt;</b>
or <b>=</b>) at the beginning of each of your search values to specify how the comparison should be done.
</p>

<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'area-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'columns'=>array(
		array(
                    'name'=>'createDate',
                    'value'=>'$data->createDate->sec',
                    'type'=>'datetime',
                    ),
		array(
                    'name'=>'updateDate',
                    'value'=>'$data->updateDate->sec',
                    'type'=>'datetime',
                    ),
		'_id',
		array(
			'class'=>'CButtonColumn',
		),
	),
)); ?>