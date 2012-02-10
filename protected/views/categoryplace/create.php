<?php
$this->breadcrumbs=array(
	'Category Places'=>array('admin'),
	'Create',
);

$this->menu=array(
	array('label'=>'Manage CategoryPlace', 'url'=>array('admin')),
);
?>

<h1>Create CategoryPlace</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>