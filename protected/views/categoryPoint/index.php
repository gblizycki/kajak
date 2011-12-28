<?php
$this->breadcrumbs=array(
	'Category Points',
);

$this->menu=array(
	array('label'=>'Create CategoryPoint', 'url'=>array('create')),
	array('label'=>'Manage CategoryPoint', 'url'=>array('admin')),
);
?>

<h1>Category Points</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>