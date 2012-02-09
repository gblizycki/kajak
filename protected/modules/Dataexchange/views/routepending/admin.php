<?php
$this->breadcrumbs=array(
	'Route Pendings'=>array('index'),
	'Manage',
);

$this->menu=array(
	array('label'=>'Create RoutePending', 'url'=>array('create')),
);

?>

<h1>Manage Route Pendings</h1>

<p>
You may optionally enter a comparison operator (<b>&lt;</b>, <b>&lt;=</b>, <b>&gt;</b>, <b>&gt;=</b>, <b>&lt;&gt;</b>
or <b>=</b>) at the beginning of each of your search values to specify how the comparison should be done.
</p>

<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'route-pending-grid',
	'dataProvider'=>$model->search(), 
	'filter'=>$model,
	'columns'=>array(
		'authorId',
		'category',
		array(
                    'name'=>'points',
                    //'type'=>'text',
                    'value'=>'$data->pointsList'
                ),
		'objectId',
		'_id',
		//'info',
		/*
		'style',
		*/
		array(
			'class'=>'CButtonColumn',
                        'template'=>'{view}{accept}{delete}',
                        'buttons'=>array
                        (

                                'accept' => array
                                (
                                        'imageUrl'=>Yii::app()->request->baseUrl.'/css/accept.png',
                                        'options'=>array('title'=>'Accept'),
                                        'url' => 'Yii::app()->createUrl("/DataExchange/routepending/accept", array("id"=>$data->id))',
                                ),
                        ),
		),
	),
)); ?>