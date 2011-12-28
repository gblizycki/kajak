<?php
$this->breadcrumbs=array(
	'Category Areas',
);

$this->menu=array(
	array('label'=>'Create CategoryArea', 'url'=>array('create')),
	array('label'=>'Manage CategoryArea', 'url'=>array('admin')),
);
?>

<h1>Category Areas</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>