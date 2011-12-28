<?php
$this->breadcrumbs=array(
	'Category Routes'=>array('index'),
	'Manage',
);

$this->menu=array(
	array('label'=>'List CategoryRoute', 'url'=>array('index')),
	array('label'=>'Create CategoryRoute', 'url'=>array('create')),
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$.fn.yiiGridView.update('category-route-grid', {
		data: $(this).serialize()
	});
	return false;
});
");

?>

<h1>Manage Category Routes</h1>

<p>
You may optionally enter a comparison operator (<b>&lt;</b>, <b>&lt;=</b>, <b>&gt;</b>, <b>&gt;=</b>, <b>&lt;&gt;</b>
or <b>=</b>) at the beginning of each of your search values to specify how the comparison should be done.
</p>

<?php echo CHtml::link('Advanced Search','#',array('class'=>'search-button')); ?>
<div class="search-form" style="display:none">
<?php $this->renderPartial('_search',array(
	'model'=>$model,
)); ?>
</div><!-- search-form -->

<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'category-route-grid',
	'dataProvider'=>new EMongoDocumentDataProvider($model->search(), array(
		'sort'=>array(
			'attributes'=>array(
				'name',
				'description',
				'title',
				'filters',
				'_id',
				'style',
			),
		),
	)),
	'filter'=>$model,
	'columns'=>array(
		'name',
		'description',
		'title',
		'filters',
		'_id',
		'style',
		array(
			'class'=>'CButtonColumn',
		),
	),
)); ?>