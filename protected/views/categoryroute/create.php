<?php
$this->breadcrumbs=array(
	'Category Routes'=>array('admin'),
	'Create',
);

$this->menu=array(
	array('label'=>'Manage CategoryRoute', 'url'=>array('admin')),
);
?>

<h1>Create CategoryRoute</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>