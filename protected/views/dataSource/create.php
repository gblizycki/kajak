<?php
$this->breadcrumbs=array(
	'Data Sources'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List DataSource', 'url'=>array('index')),
	array('label'=>'Manage DataSource', 'url'=>array('admin')),
);
?>

<h1>Create DataSource</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>