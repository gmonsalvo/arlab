<?php
$this->breadcrumbs=array(
	'Movimientos Stocks',
);

$this->menu=array(
	array('label'=>'Create MovimientosStock', 'url'=>array('create')),
	array('label'=>'Manage MovimientosStock', 'url'=>array('admin')),
);
?>

<h1>Movimientos Stocks</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
