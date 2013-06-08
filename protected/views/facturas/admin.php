<?php

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$.fn.yiiGridView.update('facturas-grid', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<h1>Listado de Facturas Emiridas</h1>


<?php 

$this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'facturas-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'columns'=>array(
		array(        
		      'name'=>'numero',
		      'header'=>'Numero',
		      'value'=>'str_pad($data->puntoVenta,4, "0", STR_PAD_LEFT)."-".str_pad($data->numero,7, "0", STR_PAD_LEFT)',
		    ),
		'fecha',
		array(        
		      'name'=>'clienteId',
		      'header'=>'Cliente',
		      'value'=>'$data->cliente->razonSocial',
                      'filter'=>  CHtml::listData(Clientes::model()->findAll(array('order'=>'razonSocial')), 'id', 'razonSocial'),  
		    ),
		'montoTotal',
            	'userStamp',
                'timeStamp',
                array(        
		      'name'=>'numero',
		      'header'=>'Accion',
		      'value'=>'CHtml::link("Ver",Yii::app()->createUrl("/facturas/facturaPDF", array("id"=>$data["id"])),array("target"=>"_blank"))',
                      'type'=>'raw',
             	    ),
		
	),
)); 
?>
