<?php
$this->breadcrumbs=array(
	'Places'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List Place', 'url'=>array('index')),
	array('label'=>'Manage Place', 'url'=>array('admin')),
);
?>

<h1>Create Place</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>