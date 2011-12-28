<?php
$this->breadcrumbs=array(
	'Category Routes',
);

$this->menu=array(
	array('label'=>'Create CategoryRoute', 'url'=>array('create')),
	array('label'=>'Manage CategoryRoute', 'url'=>array('admin')),
);
?>

<h1>Category Routes</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>