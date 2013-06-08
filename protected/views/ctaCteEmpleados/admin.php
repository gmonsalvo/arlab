<?php

$this->menu=array(
	array('label'=>'Agregar Honorario', 'url'=>array('createHonorario')),
	array('label'=>'Agregar Pago', 'url'=>array('createPago')),
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$.fn.yiiGridView.update('cta-cte-empleados-grid', {
		data: $(this).serialize()
	});
	return false;
})
;");
?>

<h1>Cta Cte Empleados</h1>


<div class="search-form">
<?php $this->renderPartial('_search',array(
	'model'=>$model,
)); ?>
</div><!-- search-form -->

<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'cta-cte-empleados-grid',
	'dataProvider'=>$model->search(),
	'columns'=>array(
		'id',
		'fecha',
		array(
		'name'=>'tipoMov',
		'header'=>'Tipo Mov.',
		'value'=>'$data->tipoMov==0 ? "Debito":"Credito"',
		),
	
		array(
			'name'=>'conceptoId',
			'header'=>'Concepto',
			'value'=>'$data->concepto->nombre',
		),        
		'periodo',
		'monto',
		'descripcion',
		'userStamp',
		'timeStamp',
		array(
			'name'=>'tipoMov',
			'header'=>'Recibo',
			'type'=>'raw'
			'value'=>'$data->tipoMov==0 ? CHtml::link("Emitir",Yii::app()->createUrl("/recibos/ReciboPDF", array("id"=>$data["id"])),array("target"=>"_blank")):""',
		),

		
	),
)); ?>
