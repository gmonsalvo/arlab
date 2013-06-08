<?php
$this->breadcrumbs = array(
    'Movimientos Stocks' => array('index'),
    'Manage',
);

$this->menu = array(
    array('label' => 'Movimiento Entre Depositos', 'url' => array('movimientosDepositos/create')),
    array('label' => 'Nuevo Movimientos Manual', 'url' => array('create')),
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$.fn.yiiGridView.update('movimientos-stock-grid', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<h1>Log de Movimientos de Stock</h1>

<?php
$this->widget('zii.widgets.grid.CGridView', array(
    'id' => 'movimientos-stock-grid',
    'dataProvider' => $model->search(),
    'filter' => $model,
    'columns' => array(
        'fecha',
        array(
            'name' => 'tipoMov',
            'header' => 'Tipo Movimiento',
            'value' => '($data->tipoMov)==0?"  >>>>":"   <<<<"',
        ),
        array(
            'name' => 'depositoId',
            'header' => 'Deposito',
            'value' => '$data->deposito->descripcion',
              'filter'=>  CHtml::listData(Depositos::model()->findAll(), 'id', 'descripcion'),
        ),
        array(
            'name' => 'equipoId',
            'header' => 'Equipamiento',
            'value' => '$data->equipo->descripcion',
             'filter'=>  CHtml::listData(Equipos::model()->findAll(), 'id', 'descripcion'),
        ),
        'cantidad',
        'observaciones',
    ),
));
?>
