<?php
$this->breadcrumbs=array(
	'Area Pendings'=>array('admin'),
	'Create',
);

$this->menu=array(
	array('label'=>'Manage AreaPending', 'url'=>array('admin')),
);
?>

<h1>Create AreaPending</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>