<?php
//armamos el date con la fecha seleccionada

if (isset($_GET['year']))
{
  $fechaActual=$_GET['year'].'-'.str_pad($_GET['month'], 2, "0", STR_PAD_LEFT).'-'.str_pad($_GET['day'], 2, "0", STR_PAD_LEFT);
}else{
  $fechaActual=date("Y-m-d");
}


$this->menu=array(
	array('label'=>'Agendar Soporte', 'url'=>array('create', 'tipoEvento'=>'0','fecha'=>$fechaActual)),
	array('label'=>'Agendar Instalacion', 'url'=>array('createInstalacion', 'tipoEvento'=>'1','fecha'=>$fechaActual)),
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$.fn.yiiGridView.update('eventos-grid', {
		data: $(this).serialize()
	});
	return false;
});
");
?>
<h3>Agenda de Instalaciones y Soportes</h3>
<h3>Fecha Seleccionada:<?php echo $fechaActual?></h3>

<?php 

$this->widget('ext.simple-calendar.SimpleCalendarWidget');

?>

<h3>Instalaciones Programadas</h3>
<div class="grid-view">
    <table class="items">
        <thead>
            <tr>
                <th>Hora</th>
                <th>Cliente</th>
                <th>Direccion</th>
                <th>Telefono</th>
                <th>Barrio</th>
                <th>Ciudad</th>
                <th>observaciones</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            <?php
            //obtenemos las instalaciones para el dia seleccionado
            $Instalaciones=$model->getInstalaciones($fechaActual);

            foreach ($Instalaciones as $instalacion) {

                $solicitud = Solicitudes::model()->findByPK($instalacion->eventoRelacionadoId);
                echo "<tr><td>" . $instalacion->hora.
                "</td><td>" . $solicitud->razonSocial.
                "</td><td>" . $solicitud->direccion.
                "</td><td>" . $solicitud->telefono .
                "</td><td>" . $solicitud->barrio->nombre .
                "</td><td>" . $solicitud->ciudad->nombre.
                "</td><td>" . $instalacion->observaciones.
                "</td><td>" . CHtml::link('Reprogramar',array('solicitudes/update','id'=>$solicitud->id))." | ".CHtml::link('Cancelar',array('solicitudes/delete','id'=>$solicitud->id)).
                "</td></tr>";

                
            }
            ?>           
        </tbody>
    </table>
</div>    



