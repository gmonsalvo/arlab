<?php

$this->menu=array(
	array('label'=>'Nueva Solicitud', 'url'=>array('create')),
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$.fn.yiiGridView.update('solicitudes-grid', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<h1>Listado de Solicitudes de Servicio</h1>



<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'solicitudes-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'columns'=>array(
		'id',
		'fecha',
		'cuit',
		'razonSocial',
		'condidicionIvaId',
		'direccion',
		'barrioId',
		'ciudadId',
		'provinciaId',
		'telefono',
		'mail',
		'userStamp',
		/*
		'timeStamp',
		*/
		array(
			'class'=>'CButtonColumn',
		),
	),
)); ?>
