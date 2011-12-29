<?php
$this->breadcrumbs=array(
	'Place Pendings'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List PlacePending', 'url'=>array('index')),
	array('label'=>'Manage PlacePending', 'url'=>array('admin')),
);
?>

<h1>Create PlacePending</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>