<?php
$this->breadcrumbs=array(
	'Category Routes'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List CategoryRoute', 'url'=>array('index')),
	array('label'=>'Manage CategoryRoute', 'url'=>array('admin')),
);
?>

<h1>Create CategoryRoute</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>