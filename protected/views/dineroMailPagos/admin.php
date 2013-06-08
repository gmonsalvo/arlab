<?php

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$.fn.yiiGridView.update('dinero-mail-pagos-grid', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<h1>Registro de Pagos</h1>


<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'dinero-mail-pagos-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'columns'=>array(
		'id',
		'fechaPago',
		'monto',
		'montoNeto',
		'numeroTransaccion',
		array(        
		      'name'=>'clienteId',
		      'header'=>'Cliente',
		      'value'=>'$data->cliente->razonSocial',
		   ),
		'nroPagoElectronico',
			
		array
                (
                    'class'=>'CButtonColumn',
                    'template'=>'{finalizar}',
                    'buttons'=>array
                    (
                        'finalizar' => array
                        (
                            'label'=>'Acreditar Pago',
                            'visible'=>'$data->estado != 1',
                            'imageUrl'=>Yii::app()->request->baseUrl.'/images/entrega.gif',
                            'url'=>'Yii::app()->createUrl("dineroMailPagos/acreditar", array("id"=>$data->id))',
                        ),
                    ),
                ),
	),
)); ?>
