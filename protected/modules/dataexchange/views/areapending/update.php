<?php
$this->breadcrumbs=array(
	'Area Pendings'=>array('admin'),
	$model->id=>array('view','id'=>$model->_id),
	'Update',
);

$this->menu=array(
	array('label'=>'Create AreaPending', 'url'=>array('create')),
	array('label'=>'View AreaPending', 'url'=>array('view', 'id'=>$model->_id)),
	array('label'=>'Manage AreaPending', 'url'=>array('admin')),
);
?>

<h1>Update AreaPending <?php echo $model->_id; ?></h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>