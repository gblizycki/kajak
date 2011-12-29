<?php
$this->breadcrumbs=array(
	'Place Pendings'=>array('index'),
	$model->id=>array('view','id'=>$model->_id),
	'Update',
);

$this->menu=array(
	array('label'=>'List PlacePending', 'url'=>array('index')),
	array('label'=>'Create PlacePending', 'url'=>array('create')),
	array('label'=>'View PlacePending', 'url'=>array('view', 'id'=>$model->_id)),
	array('label'=>'Manage PlacePending', 'url'=>array('admin')),
);
?>

<h1>Update PlacePending <?php echo $model->_id; ?></h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>