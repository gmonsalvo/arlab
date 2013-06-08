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

<h1>Listado de clientes suspendidos</h1>

<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'clientes-grid',
	'selectableRows' => 1,
    'selectionChanged' => 'Mostrar',
	'dataProvider'=>$model->searchSuspendidos(),
	'filter'=>$model,
	'columns'=>array(
		'id',
		'razonSocial',
		'fechaSuspension',
		array(        
		      'name'=>'lastUserUpdate',
		      'header'=>'Realizado Por',
		      'value'=>'$data->lastUserUpdate',
		   ),   
		array(        
		      'name'=>'ciudadId',
		      'header'=>'Ciudad',
		      'value'=>'$data->ciudad->nombre',
		   ),   
		'direccion',
		'telefono',
	     array
			(
    			'class'=>'CButtonColumn',
    			'template'=>'{view}',
			),
	),
)); ?>
