<?php
$this->breadcrumbs=array(
	'Category Areas'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List CategoryArea', 'url'=>array('index')),
	array('label'=>'Manage CategoryArea', 'url'=>array('admin')),
);
?>

<h1>Create CategoryArea</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>