<?php
$this->menu=array(

	array('label'=>'Nueva Rendicion', 'url'=>array('create')),
);

?>

<h1>Listado de Rendiciones</h1>


<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'rendiciones-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'columns'=>array(
		'id',
		'fecha',
		'periodoInicio',
		'periodoFin',
			array(
		      'name'=>'cobradorId',
		      'header'=>'Cobrador',
		      'value'=>'$data->cobrador->descripcion',
		   ),
		array(
		      'name'=>'estado',
		      'header'=>'Estado',
		      'value'=>'($data->estado)==1?"Cerrada":"Abierta"',
		   ),
		array
                (
                    'class'=>'CButtonColumn',
                    'template'=>'{emitir}{finalizar}',
                    'buttons'=>array
                    (
                        'finalizar' => array
                        (
                            'label'=>'Finalizar',
                            'visible'=>'$data->estado != 1',
                            'imageUrl'=>Yii::app()->request->baseUrl.'/images/entrega.gif',
                            'url'=>'Yii::app()->createUrl("rendiciones/finalizar", array("id"=>$data->id))',
                        ),
                        'emitir' => array
                        (
                            'label'=>'Emision Masiva',
                            'imageUrl'=>Yii::app()->request->baseUrl.'/images/alta.gif',
                            'url'=>'Yii::app()->createUrl("rendiciones/reciboMasivoPdf", array("id"=>$data->id))',
                        ),
                    ),
                ),
	),
)); ?>
