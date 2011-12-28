<?php
$this->breadcrumbs=array(
	'Category Places'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List CategoryPlace', 'url'=>array('index')),
	array('label'=>'Manage CategoryPlace', 'url'=>array('admin')),
);
?>

<h1>Create CategoryPlace</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>