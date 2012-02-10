<?php
$this->breadcrumbs=array(
	'Route Pendings'=>array('admin'),
	$model->id=>array('view','id'=>$model->_id),
	'Update',
);

$this->menu=array(
	array('label'=>'Create RoutePending', 'url'=>array('create')),
	array('label'=>'View RoutePending', 'url'=>array('view', 'id'=>$model->_id)),
	array('label'=>'Manage RoutePending', 'url'=>array('admin')),
);
?>

<h1>Update RoutePending <?php echo $model->_id; ?></h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>