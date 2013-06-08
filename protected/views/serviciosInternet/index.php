<?php
$this->breadcrumbs=array(
	'Servicios Internets',
);

$this->menu=array(
	array('label'=>'Create ServiciosInternet', 'url'=>array('create')),
	array('label'=>'Manage ServiciosInternet', 'url'=>array('admin')),
);
?>

<h1>Servicios Internets</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
