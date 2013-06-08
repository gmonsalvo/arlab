<?php
$this->breadcrumbs=array(
	'Gestiones Solicitudes',
);

$this->menu=array(
	array('label'=>'Create GestionesSolicitudes', 'url'=>array('create')),
	array('label'=>'Manage GestionesSolicitudes', 'url'=>array('admin')),
);
?>

<h1>Gestiones Solicitudes</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
