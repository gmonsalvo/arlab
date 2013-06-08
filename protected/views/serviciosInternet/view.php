<?php
/*$comm = "ping -c3 192.168.1.5";
$output=shell_exec($comm);
echo $output;
*/
 ?>

<?php

$this->menu=array(
	array('label'=>'Volver a la hoja del Cliente', 'url'=>array('/clientes/view','id'=>$model->cliente->id)),
	array('label'=>'Upgrade/Downgrade', 'url'=>array('/cambioPlan/create','servicioInternetId'=>$model->id)),
);
?>

<h1>Servicio de Internet #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'domicilio',
		 array(
              'label'=>'Ciudad',
              'value'=>$model->ciudad->nombre,
              ),
	    array(
              'label'=>'Barrio',
              'value'=>$model->barrio->nombre,
              ),
		'telefono',
		'fecha_instalacion',
		array(
              'label'=>'Servidor/Gateway',
              'value'=>$model->servidor->nombre,
              ),
		array(
              'label'=>'Repetidor',
			  'type'=>'html',
              'value'=>$model->repetidor->nombre."  [ <a href='http://".$model->repetidor->ip_lan."/login.cgi?username=ubnt&password=pascal098deal'>".$model->repetidor->ip_lan."</a> ]",
              ),
		'nivel_senal',
		'ip_lan',
		array(
              'label'=>'IP Antena',
			  'type'=>'html',
              'value'=> "<a href='http://".$model->ip_antena."' >".$model->ip_antena."</a>",
              ),
		array(
              'label'=>'Equipo',
              'value'=>$model->equipo->descripcion,
              ),
		array(
              'label'=>'Ciclo',
              'value'=>$model->ciclo->descripcion,
              ),
		'costoServicio',
             array(
              'label'=>'Plan Contratado',
              'value'=>$model->plan->descripcion,
              ),
            array(
              'label'=>'Instaladores',
              'value'=>$model->instaladores->descripcion,
              ),
	),
)); ?>
