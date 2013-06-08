<?php

$this->menu=array(
	array('label'=>'Nuevo Plan', 'url'=>array('create')),
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$.fn.yiiGridView.update('planes-grid', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<h1>Administracion de Planes</h1>



<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'planes-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'columns'=>array(
		'id',
		'descripcion',
		'subida',
		'bajada',
		'costo',
		array(
			'class'=>'CButtonColumn',
		),
	),
)); ?>
