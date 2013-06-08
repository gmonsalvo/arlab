<?php
$this->breadcrumbs=array(
	'Facturases'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List Facturas', 'url'=>array('index')),
	array('label'=>'Manage Facturas', 'url'=>array('admin')),
);
?>

<h1>Nueva Factura</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model, 'notaVenta' => $notaVenta, 'cliente'=>$cliente, 'documento' => $documento)); ?>