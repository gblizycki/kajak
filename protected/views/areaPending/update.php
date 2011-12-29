<?php
$this->breadcrumbs=array(
	'Area Pendings'=>array('index'),
	$model->id=>array('view','id'=>$model->_id),
	'Update',
);

$this->menu=array(
	array('label'=>'List AreaPending', 'url'=>array('index')),
	array('label'=>'Create AreaPending', 'url'=>array('create')),
	array('label'=>'View AreaPending', 'url'=>array('view', 'id'=>$model->_id)),
	array('label'=>'Manage AreaPending', 'url'=>array('admin')),
);
?>

<h1>Update AreaPending <?php echo $model->_id; ?></h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>