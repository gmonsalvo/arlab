<?php
$this->breadcrumbs=array(
	'Recibos Nota Ventas'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List RecibosNotaVenta', 'url'=>array('index')),
	array('label'=>'Manage RecibosNotaVenta', 'url'=>array('admin')),
);
?>

<h1>Create RecibosNotaVenta</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>