<?php
$this->breadcrumbs=array(
	'Data Sources'=>array('admin'),
	'Create',
);

$this->menu=array(
	array('label'=>'Manage DataSource', 'url'=>array('admin')),
);
?>

<h1>Create DataSource</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>