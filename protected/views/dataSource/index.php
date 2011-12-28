<?php
$this->breadcrumbs=array(
	'Data Sources',
);

$this->menu=array(
	array('label'=>'Create DataSource', 'url'=>array('create')),
	array('label'=>'Manage DataSource', 'url'=>array('admin')),
);
?>

<h1>Data Sources</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>