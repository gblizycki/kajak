<?php
$this->breadcrumbs=array(
	'Data Sources'=>array('index'),
	$model->id=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>'List DataSource', 'url'=>array('index')),
	array('label'=>'Create DataSource', 'url'=>array('create')),
	array('label'=>'View DataSource', 'url'=>array('view', 'id'=>$model->_id)),
	array('label'=>'Manage DataSource', 'url'=>array('admin')),
);
?>

<h1>Update DataSource <?php echo $model->_id; ?></h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>