<?php
$this->breadcrumbs=array(
	'Data Sources'=>array('index'),
	'Manage',
);
?>

<h1>Manage Data Sources</h1>

<p>
You may optionally enter a comparison operator (<b>&lt;</b>, <b>&lt;=</b>, <b>&gt;</b>, <b>&gt;=</b>, <b>&lt;&gt;</b>
or <b>=</b>) at the beginning of each of your search values to specify how the comparison should be done.
</p>

<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'data-source-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'columns'=>array(
		'format',
		'version',
		'_id',
		array(
			'class'=>'CButtonColumn',
		),
	),
)); ?>