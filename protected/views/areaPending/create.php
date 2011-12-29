<?php
$this->breadcrumbs=array(
	'Area Pendings'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List AreaPending', 'url'=>array('index')),
	array('label'=>'Manage AreaPending', 'url'=>array('admin')),
);
?>

<h1>Create AreaPending</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>