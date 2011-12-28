<?php
$this->breadcrumbs=array(
	'Category Places',
);

$this->menu=array(
	array('label'=>'Create CategoryPlace', 'url'=>array('create')),
	array('label'=>'Manage CategoryPlace', 'url'=>array('admin')),
);
?>

<h1>Category Places</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>