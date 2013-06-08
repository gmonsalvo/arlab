<script>
function Mostrar(id){
    //si hay alguno seleccionado
       
	if($.fn.yiiGridView.getSelection(id)!=''){
	     window.location.href = $.fn.yiiGridView.getSelection(id);
    }
    
}
</script>
<?php


Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$.fn.yiiGridView.update('clientes-grid', {
		data: $(this).serialize()
	});
	return false;
});
");

$this->menu=array(
	array('label'=>'Nuevo Cliente', 'url'=>array('create')));
	
?>

<h1>Administracion de Clientes</h1>

<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'clientes-grid',
	'selectableRows' => 1,
    'selectionChanged' => 'Mostrar',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'columns'=>array(
		'id',
		'razonSocial',
		array(        
		      'name'=>'condicionIvaId',
		      'header'=>'Condicion IVA',
		      'value'=>'$data->condicionIva->nombre',
		      'filter'=>  CHtml::listData(CondicionesIva::model()->findAll(array('order'=>'nombre')), 'id', 'nombre'),  
		   ),
                array(
                    'name' => 'cuentaOrden',
                    'header' => 'Cuenta y Orden',
                    'value' => '($data->cuentaOrden == 1) ? "SI":"NO"',
                    'htmlOptions'=>array('style'=>'text-align: right'),
			),
		array(        
		      'name'=>'ciudadId',
		      'header'=>'Ciudad',
		      'value'=>'$data->ciudad->nombre',
		   ),   
		'direccion',
		'cuit',
		'codigoPagoElectronico',
		'telefono',
		'mail',
		/*
		'web',
		'infoAdicional',
		'ciudadId',
		*/
		array(
			'class'=>'CButtonColumn',
		),
	),
)); ?>
