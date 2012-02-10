<?php
$this->breadcrumbs=array(
	'Place Pendings'=>array('admin'),
	'Create',
);

$this->menu=array(
	array('label'=>'Manage PlacePending', 'url'=>array('admin')),
);
?>

<h1>Create PlacePending</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>