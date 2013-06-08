<h1>Historial de Pagos Electronicos</h1>


<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'pagos-electronicos-grid',
	'dataProvider'=>$model->search(),
	
	'columns'=>array(
		'id',
		'fecha',
		array(        
		      'name'=>'clienteId',
		      'header'=>'Cliente',
		      'value'=>'$data->cliente->razonSocial',
		),
		'procesadorPago',
		'monto',
		array(        
		      'name'=>'estado',
		      'header'=>'Estado',
		      'value'=>'($data->estado)==1?"ACREDITADO":"PENDIENTE"',
		   ),
		'fechaAcreditacion',
		array
                (
                    'class'=>'CButtonColumn',
                    'template'=>'{finalizar}',
                    'buttons'=>array
                    (
                        'finalizar' => array
                        (
                            'label'=>'Acreditar',
                            'visible'=>'$data->estado != 1',
                            'imageUrl'=>Yii::app()->request->baseUrl.'/images/entrega.gif',
                            'url'=>'Yii::app()->createUrl("clientes/finalizarPagoElectronico", array("id"=>$data->id))',
                        ),
                    ),
                ),
	),
)); ?>
