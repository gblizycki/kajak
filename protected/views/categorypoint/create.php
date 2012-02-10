<?php
$this->breadcrumbs=array(
	'Category Points'=>array('admin'),
	'Create',
);

$this->menu=array(
	array('label'=>'Manage CategoryPoint', 'url'=>array('admin')),
);
?>

<h1>Create CategoryPoint</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>