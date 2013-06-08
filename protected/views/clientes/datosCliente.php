<?php
//ponemos el si y el no en cuenta y orden
if ($model->cuentaOrden==1){
  $cuentaOrden="SI";     
}else {
  $cuentaOrden="NO";        
}
$this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'razonSocial',
		'cuit',		
		array(
               'label' => 'Condicion IVA',
               'value' => $model->condicionIva->nombre
                ),
		array(
               'label' => 'Cuenta y Orden',
               'value' => $cuentaOrden
                ),		
		'direccion',
		 array(
               'label' => 'Ciudad',
               'value' => $model->ciudad->nombre
                ),
		array(
               'label' => 'Barrio',
               'value' => $model->barrio->nombre
                ), 
		'telefono',
		'mail',
		'interno',
		'codigoPagoElectronico',
		 array(
               'label' => 'Cobrador',
               'value' => $model->cobrador->descripcion
                ),
		'infoAdicional',
		array(
               'label' => 'SALDO ACTUAL',
			   'type' => 'html',
               'value' => "<b> $".number_format($model->getSaldo(),2)."</b>         <a href=../ctaCteClientes/admin?clienteId=".$model->id.">   Ver Detalle<a/>"
			   ),
		'userStamp',	
		'lastUserUpdate',	
	),
));

 ?>
