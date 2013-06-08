<?php

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$.fn.yiiGridView.update('recibos-grid', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<h1>Listado de Recibos Emitidos</h1>

<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'recibos-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'columns'=>array(
		array(        
		      'name'=>'numero',
		      'header'=>'Numero',
		      'value'=>'str_pad($data->sucursal,4, "0", STR_PAD_LEFT)."-".str_pad($data->numero,7, "0", STR_PAD_LEFT)',
		    ),
		'fecha',
		array(        
		      'name'=>'clienteId',
		      'header'=>'Cliente',
		      'type'=> 'raw',
		      'value'=>'CHtml::link($data->cliente->razonSocial,Yii::app()->createUrl("/clientes/view/", array("id"=>$data["clienteId"])),array("target"=>"_blank"))',
              'filter'=>  CHtml::listData(Clientes::model()->findAll(array('order'=>'razonSocial')), 'id', 'razonSocial'),  
		    ),
		'montoTotal',
            	'userStamp',
                'timeStamp',
                array(        
		      'name'=>'numero',
		      'header'=>'Accion',
		      'value'=>'CHtml::link("Ver",Yii::app()->createUrl("/recibos/ReciboPDF", array("id"=>$data["id"])),array("target"=>"_blank"))',
              'type'=>'raw',
              ),
		
	),
)); 

?>

