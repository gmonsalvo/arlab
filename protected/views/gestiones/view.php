<?php
if ($model->estado==0){
$opciones=array(
    array('label' => 'Nueva Entrada', 'url' => array('gestiones/createHijo', 'gestionPadreId' => $model->id, 'clienteId' => $model->clienteId, 'tipoGestionId' => $model->tema->tipoGestionId, 'temaId' => $model->temaId)),
    array('label' => 'Cerrar Gestion', 'url' => array('gestiones/cerrar', 'gestionPadreId' => $model->id, 'clienteId' => $model->clienteId, 'tipoGestionId' => $model->tema->tipoGestionId, 'temaId' => $model->temaId)),
    array('label' => '<hr>'),
    array('label' => 'Volver a Listado de Soportes', 'url' => 'soportes'),
    array('label' => 'Volver a Hoja del Cliente', 'url' => '../clientes/' . $model->clienteId),
);
}else{
  $opciones=array(
    array('label' => 'Volver a Listado de Soportes', 'url' => 'soportes'),
    array('label' => 'Volver a Hoja del Cliente', 'url' => '../clientes/' . $model->clienteId),
);
    
}

$this->menu =$opciones; 
?>
<?php
$mensaje = "";
if ($model->tema->tipoGestionId == 3) {

    $mensaje = " Soporte Tecnico";
}
?>
<h1>Viendo la Gestion Inicial de <?php echo $mensaje . "  #" . $model->id; ?></h1>

<?php
$this->widget('zii.widgets.CDetailView', array(
    'data' => $model,
    'attributes' => array(
        'id',
        'fecha',
        array(
            'label' => 'Cliente',
            'value' => $model->cliente->razonSocial
        ),
        array(
            'label' => 'Domicilio Cliente',
            'value' => $model->cliente->ciudad->nombre."-".$model->cliente->direccion
        ),
        array(
            'label' => 'Telefonos Cliente',
            'value' => $model->cliente->telefono
        ),

        array(
            'label' => 'Topico de la Gestion',
            'value' => $model->tema->descripcion
        ),
        'detalle',
        array(
            'label' => 'Estado',
            'value' => $model->estado == 0 ? "ABIERTO" : "CERRADO",
        ),
        array(
            'label' => 'Responsable Asignado',
            'value' => $model->usuario->username
        ),
        'userStamp',
        'timeStamp'
    ),
));
?>
<br>
<h1>Historial</h1>
<?php
$this->widget('zii.widgets.CListView', array(
    'dataProvider' => $model->gestionesHijas($model->id),
    'itemView' => '_view',
));
?>
