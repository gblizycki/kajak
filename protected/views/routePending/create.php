<?php
$this->breadcrumbs=array(
	'Route Pendings'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List RoutePending', 'url'=>array('index')),
	array('label'=>'Manage RoutePending', 'url'=>array('admin')),
);
?>

<h1>Create RoutePending</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>