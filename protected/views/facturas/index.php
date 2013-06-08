<?php
$this->breadcrumbs=array(
	'Facturases',
);

$this->menu=array(
	array('label'=>'Create Facturas', 'url'=>array('create')),
	array('label'=>'Manage Facturas', 'url'=>array('admin')),
);
?>

<h1>Facturases</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
