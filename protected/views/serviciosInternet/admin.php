<?php

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$.fn.yiiGridView.update('servicios-internet-grid', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<h1>Busqueda de Servicios</h1>

<div class="search-form" >
<?php $this->renderPartial('_search',array(
	'model'=>$model,
)); ?>
</div><!-- search-form -->

<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'servicios-internet-grid',
	'dataProvider'=>$model->search(),
	'columns'=>array(
		'id',
		'fecha_instalacion',
		array(        
		      'name'=>'clienteId',
		      'header'=>'Cliente',
		      'value'=>'$data->cliente->razonSocial',
		   ),   
		'domicilio',
		array(        
		      'name'=>'ciudadId',
		      'header'=>'Ciudad',
		      'value'=>'$data->ciudad->nombre',
		   ),   
	
		array(        
		      'name'=>'servidorId',
		      'header'=>'Servidor',
		      'value'=>'$data->servidor->nombre',
		   ),   
		array(        
		      'name'=>'repetidorId',
		      'header'=>'Repetidor',
		      'value'=>'$data->repetidor->nombre',
		   ), 
		
		'ip_lan',
		'ip_antena',
		array(        
		      'name'=>'equipoId',
		      'header'=>'Equipamiento',
		      'value'=>'$data->equipo->descripcion',
		   ), 
		
		'costoServicio',
		array(        
		      'name'=>'planId',
		      'header'=>'Plan',
		      'value'=>'$data->plan->descripcion',
		   ), 
		
	
		array(
			'class'=>'CButtonColumn',
		),
	),
)); ?>
