<?php
$this->breadcrumbs=array(
	'Recibos Nota Ventas',
);

$this->menu=array(
	array('label'=>'Create RecibosNotaVenta', 'url'=>array('create')),
	array('label'=>'Manage RecibosNotaVenta', 'url'=>array('admin')),
);
?>

<h1>Recibos Nota Ventas</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
