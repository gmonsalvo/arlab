<?php

$this->menu=array(
	array('label'=>'Nuevo Cliente', 'url'=>array('create')),
	array('label'=>'Modicar Cliente Actual', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Eliminar Clientes', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Esta Seguro?')),
	array('label'=>'Listado Clientes', 'url'=>array('admin')),
	array('label'=>'<hr>'),
        array('label'=>'Nuevo Servicio Internet', 'url'=>array('serviciosInternet/create', 'clienteId'=>$model->id)),
	array('label'=>'Nuevo Servicio VOIP', 'url'=>array('serviciosVoip/create', 'clienteId'=>$model->id)),
	array('label'=>'<hr>'),
        array('label'=>'Cobrar', 'url'=>array('recibos/create', 'clienteId'=>$model->id)),
    	array('label'=>'Nueva Venta', 'url'=>array('notaVenta/create', 'clienteId'=>$model->id)),
    	array('label'=>'Nueva Factura', 'url'=>array('facturas/create', 'id'=>$model->id)),
               
        array('label'=>'<hr>'),
        array('label'=>'Gestiones'),
        array('label'=>'Nuevo Soporte Tecnico', 'url'=>array('gestiones/create', 'clienteId'=>$model->id,'tipoGestionId'=>'3')),
    	array('label'=>'Cobranzas', 'url'=>array('gestiones/create', 'clienteId'=>$model->id,'tipoGestionId'=>'1')),
    	array('label'=>'Ventas', 'url'=>array('clientes/baja', 'id'=>$model->id)),
);



?>

<font size="4"><b><?php 
echo $model->razonSocial;
if ($model->estado==Clientes::ESTADO_ACTIVO)
    echo "<font color=green> [ACTIVO]</font>";
if ($model->estado==Clientes::ESTADO_BAJA)
    echo "<font color=red>  [BAJA] Fecha Baja:".$model->fechaBaja."</font>";
if ($model->estado==Clientes::ESTADO_SUSPENDIDO)
    echo "<font color=orange>  [SUSPENDIDO] Fecha Susp.:".$model->fechaSuspension."</font>";
?>
</b>
<br>
<?php
//botonera
if ($model->estado==Clientes::ESTADO_ACTIVO)
    echo "<font size='3'>".CHtml::link('[Suspender]',array('clientes/suspender',"id"=>$model->id))."  ".CHtml::link('[Baja]',array('clientes/baja',"id"=>$model->id))."</font>";
if ($model->estado==Clientes::ESTADO_BAJA)
echo "<font size='3'>".CHtml::link('[Suspender]',array('clientes/suspender',"id"=>$model->id))."  ".CHtml::link('[Activar]',array('clientes/activar',"id"=>$model->id))."</font>";
if ($model->estado==Clientes::ESTADO_SUSPENDIDO)
    echo "<font size='3'>".CHtml::link('[Baja]',array('clientes/baja',"id"=>$model->id))."  ".CHtml::link('[Activar]',array('clientes/activar',"id"=>$model->id))."</font>";
?>

<br><br>

Gestiones Realizadas</font>
<?php

//$config = array();
//$dataProvider = new CArrayDataProvider($rawData=Gestiones::model()->soloPadres($model->id,10), $config);
//$ver="VER";
$this->widget('zii.widgets.grid.CGridView', array(
    'dataProvider'=>Gestiones::model()->soloPadres($model->id,10)
    ,'columns'=>array(
        'id'
        ,'fecha'
	,array(        
		      'name'=>'tipoGestionId',
		      'header'=>'Tipo Gestion',
		      'value'=>'$data->tema->tipoGestion->nombre',
		   )
        ,array(        
		      'name'=>'temaId',
		      'header'=>'Topico Gestion',
		      'value'=>'$data->tema->descripcion',
		   )
	,'detalle'
        ,array(        
		      'name'=>'estado',
		      'header'=>'Estado',
		      'value'=>'$data->estado == 0 ? "ABIERTO" : "CERRADO"',
		   )
        ,array(
        'class'=>'CLinkColumn',                
        'header'=>'Accion',                     
        //'imageUrl'=>Yii::app()->theme->baseUrl.'/images/mapa.png',        
        'labelExpression'=>'$data->id',        
        'urlExpression'=> 'Yii::app()->request->baseUrl."/index.php/gestiones/".$data->id',
        'htmlOptions'=>array('style'=>'text-align:center;width:20px;'),        
        )
        
    )
));

$this->widget('zii.widgets.jui.CJuiTabs', array(
    'tabs' => array(
        'Datos de Cliente'=>array('id'=>'renderid',
                             'content'=>$this->renderPartial(
                                'datosCliente',
                                 array('model'=>$model),TRUE)
                              ),
        'Servicios de Internet'=>array('id'=>'renderid2',
                             'content'=>$this->renderPartial(
                                'internet',
                                 array('model'=>$model),TRUE)
                              ),
         'Servicios Voip'=>array('id'=>'renderid3',
                             'content'=>$this->renderPartial(
                                'voip',
                                 array('model'=>$model),TRUE)
                              ),
        
    ),
 
    // additional javascript options for the tabs plugin
    'options' => array(
        'collapsible' => true,
    ),
    // set id for this widgets
    'id'=>'MyTab',
));

?>


