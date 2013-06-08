<?php

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$.fn.yiiGridView.update('cambio-plan-grid', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<h1>Cambio de Planes</h1>


<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'cambio-plan-grid',
	'dataProvider'=>$model->search(),
	
	'columns'=>array(
		'fecha',
           
		array(        
		      'name'=>'accion',
		      'header'=>'Accion',
		      'value'=>'($data->accion)==1?"DOWNGRADE":"UPGRADE"',
		   ),
        'periodoInicio',
        array(        
		      'name'=>'servicioInternetId',
		      'header'=>'Cliente',
		      'value'=>'$data->servicioInternet->cliente->razonSocial',
		   ),
		'observaciones',
		array(        
		      'name'=>'planId',
		      'header'=>'Plan Destino',
		      'value'=>'$data->plan->descripcion',
		   ),
		array(        
		      'name'=>'estado',
		      'header'=>'Estado',
		      'value'=>'($data->estado)==0?"PEND.":"Fin."',
		   ),
                /*
		'costoServicio',
		'userStamp',
		'timeStamp',
		*/
		array
                (
                    'class'=>'CButtonColumn',
                    'template'=>'{finalizar}',
                    'buttons'=>array
                    (
                        'finalizar' => array
                        (
                            'label'=>'Confirmar Upgrade/Downgrade',
                            'visible'=>'$data->estado != 1',
                            'imageUrl'=>Yii::app()->request->baseUrl.'/images/entrega.gif',
                            'url'=>'Yii::app()->createUrl("cambioPlan/finalizar", array("id"=>$data->id))',
                        ),
                    ),
                ),
	),
)); ?>
