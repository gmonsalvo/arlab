<?php
$this->widget('zii.widgets.grid.CGridView', array(
    'id' => 'grid',
    'dataProvider' => $arrayDataProvider,
    'columns' => array(
        array(
            'name' => 'Cliente Id',
            'type' => 'raw',
            'value' => 'CHtml::encode($data["id"])'
        ),
        array(
            'name' => 'Razon Social',
            'type' => 'raw',
            'value' => '$data["razonSocial"]'
        ),
        array(
            'name' => 'Ciudad',
           
            'value' => 'Ciudades::model()->getNombreCiudad($data["ciudadId"])'
        ),
        array(
            'name' => 'Periodos Adeudados',
            'type' => 'raw',
            'value' => '$data["periodosAdeudados"]'
        ),
        
        array(
            'name' => 'Estado',
            'type' => 'raw',
            'value' => '$data["estadoCliente"]'
        ),
        array(
            'name' => 'Saldo',
            'type' => 'raw',
            'value' => 'number_format(Clientes::model()->getSaldoMorosos($data["id"],$data["fechaVencimiento"]),2)'
        ),
        array(
            'name' => 'Cta Cte',
            'type' => 'raw',
            'value' => 'CHtml::link("Detalle", Yii::app()->createUrl("/ctaCteClientes/admin/",array("clienteId"=>$data["id"])))',
        ),
        array(
            'name' => 'Gestion',
            'type' => 'raw',
            'value' => 'is_null(Gestiones::model()->getGestionActiva($data["id"])) ? CHtml::link("Nueva Gestion", Yii::app()->createUrl("/gestiones/create/",array("clienteId"=>$data["id"],"tipoGestionId"=>1))) :CHtml::link("Gestion Activa", Yii::app()->createUrl("/gestiones/view/",array("id"=>Gestiones::model()->getGestionActiva($data["id"]))))',
        ),
        
    ),
));

?>
