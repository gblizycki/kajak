<?php
$this->breadcrumbs=array(
	'Category Points'=>array('admin'),
	'Manage',
);

$this->menu=array(
	array('label'=>'Create CategoryPoint', 'url'=>array('create')),
);

?>

<h1>Manage Category Points</h1>

<p>
You may optionally enter a comparison operator (<b>&lt;</b>, <b>&lt;=</b>, <b>&gt;</b>, <b>&gt;=</b>, <b>&lt;&gt;</b>
or <b>=</b>) at the beginning of each of your search values to specify how the comparison should be done.
</p>

<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'category-point-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'columns'=>array(
		'name',
		'description',
		'title',
		'_id',
		array(
			'class'=>'CButtonColumn',
		),
	),
)); ?>