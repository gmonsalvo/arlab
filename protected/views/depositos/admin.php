<?php

$this->menu=array(
	array('label'=>'Nuevo Deposito', 'url'=>array('create')),
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$.fn.yiiGridView.update('depositos-grid', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<h1>Administracion de Depositos</h1>


<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'depositos-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'columns'=>array(
		'id',
		'descripcion',
		'userStamp',
		'timeStamp',
		array(
			'class'=>'CButtonColumn',
		),
	),
)); ?>
