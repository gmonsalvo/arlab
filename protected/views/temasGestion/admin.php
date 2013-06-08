<?php

$this->menu=array(
	array('label'=>'Nuevo Tema de Gestion', 'url'=>array('create')),
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$.fn.yiiGridView.update('temas-gestion-grid', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<h1>Administracion de Temas de Gestion</h1>

<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'temas-gestion-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'columns'=>array(
		'id',
		array(        
		      'name'=>'tipoGestionId',
		      'header'=>'Tipo Gestion',
		      'value'=>'$data->tipoGestion->nombre',
		   ),
            
		'descripcion',
		'userStamp',
		'timeStamp',
		array(
			'class'=>'CButtonColumn',
		),
	),
)); ?>
