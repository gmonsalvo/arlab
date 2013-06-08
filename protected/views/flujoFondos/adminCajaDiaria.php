<?php
if (isset($_GET['FlujoFondos']['periodo'])) {
	$model->periodo=$_GET['FlujoFondos']['periodo'];
}else
{ //ponemos el periodo por defecto que seria el actual

    $model->periodo=date("Y").date("m");
    $model->cuentaId=Yii::app()->params['cuentaCajaDiaria'];
}
if (in_array(Yii::app()->user->model->username, array('gmonsalvo','khaure')))
{
	$this->menu=array(
  		array('label'=>'Registrar Ingreso', 'url'=>array('createDiaria','tipoMov'=>'1','periodo'=>$model->periodo,'cuentaId'=>Yii::app()->params['cuentaCajaDiaria'])),
		array('label'=>'Registrar Egreso', 'url'=>array('createDiaria','tipoMov'=>'0','periodo'=>$model->periodo,'cuentaId'=>Yii::app()->params['cuentaCajaDiaria'])),
		array('label'=>'Pases de Caja', 'url'=>array('movimientosCuentasFlujoFondos/create','cuentaOrigen'=>Yii::app()->params['cuentaCajaDiaria'])),
	);
}else{
  	
	$this->menu=array(
		array('label'=>'Registrar Egreso', 'url'=>array('createDiaria','tipoMov'=>'0','periodo'=>$model->periodo,'cuentaId'=>Yii::app()->params['cuentaCajaDiaria'])),
		array('label'=>'Pases de Caja', 'url'=>array('movimientosCuentasFlujoFondos/create','cuentaOrigen'=>Yii::app()->params['cuentaCajaDiaria'])),
	);

}
Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$.fn.yiiGridView.update('flujo-fondos-grid', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<h3>Caja Diaria</h3>

<div class="search-form">
<?php $this->renderPartial('_search',array(
	'model'=>$model,
)); ?>
</div><!-- search-form -->

<h3>Ingresos</h3>

<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'flujo-fondos-ingresos-grid',
	'ajaxUpdate'=>'false',
	//'filter'=>$model,
	'dataProvider'=>$model->searchIngresos(),
	'columns'=>array(
		'id',
		'fecha',
		'monto',
     	array(        
		      'name'=>'conceptoId',
		      'header'=>'Concepto',
		      'value'=>'$data->concepto->nombre',
		   ),
     	array(        
		      'name'=>'tipoFondoId',
		      'header'=>'TipoFondo',
		      'value'=>'$data->tipoFondo->nombre',
		   ),

		array(        
		      'name'=>'descripcion',
		      'header'=>'Descripcion',
		      'type'=>'html',
		      'value'=>'$data->descripcion',
		   ),
		'userStamp',

	),
)); ?>

<h3>Egresos</h3>

<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'flujo-fondos-egresos-grid',
	'ajaxUpdate'=>'false',
	//'filter'=>$model,
	'dataProvider'=>$model->searchEgresos(),
	'columns'=>array(
		'id',
		'fecha',
		'monto',
     	array(        
		      'name'=>'conceptoId',
		      'header'=>'Concepto',
		      'value'=>'$data->concepto->nombre',
		   ),
		array(        
		      'name'=>'tipoFondoId',
		      'header'=>'TipoFondo',
		      'value'=>'$data->tipoFondo->nombre',
		   ),
     	
		array(        
		      'name'=>'descripcion',
		      'header'=>'Descripcion',
		      'type'=>'html',
		      'value'=>'$data->descripcion',
		   ),

	),
)); 

?>
<h3>Saldos</h3>

<?php
//Mostramos el  saldo de fondos para el periodos
$saldosTiposFondos = $model->getSaldoTiposFondos();
//print_r($saldosTiposFondos);

$this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'saldosTiposFondos-grid',
	'dataProvider'=>new CArrayDataProvider($saldosTiposFondos, array('keyField'=>'id')),
	'columns'=>array(
		array(        
		      'name'=>'nombre',
		      'header'=>'Nombre',
		      'value'=>'$data["nombre"]',
		   ),
/*		array(        
		      'name'=>'subtotalIngreso',
		      'header'=>'Ingreso',
		      'value'=>'number_format($data["subtotalIngreso"],2)',
		   ),
		array(        
		      'name'=>'subtotalEgreso',
		      'header'=>'Egreso',
		      'value'=>'number_format($data["subtotalEgreso"],2)',
		   ),*/
 		array(        
		      'name'=>'saldo',
		      'header'=>'Saldo',
		      'value'=>'number_format($data["subtotalIngreso"]-$data["subtotalEgreso"],2)',
		   ),

	),
)); 


?>
<h3>SALDO TOTAL: $ <?php echo number_format($model->getSaldoPeriodo(),2);?></h3>