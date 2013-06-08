<?php
$this->breadcrumbs=array(
	'Forma Pago Reciboses',
);

$this->menu=array(
	array('label'=>'Create FormaPagoRecibos', 'url'=>array('create')),
	array('label'=>'Manage FormaPagoRecibos', 'url'=>array('admin')),
);
?>

<h1>Forma Pago Reciboses</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
