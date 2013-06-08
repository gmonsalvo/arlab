<?php
$this->breadcrumbs=array(
	'Gestiones Soportes',
);

$this->menu=array(
	array('label'=>'Create GestionesSoportes', 'url'=>array('create')),
	array('label'=>'Manage GestionesSoportes', 'url'=>array('admin')),
);
?>

<h1>Gestiones Soportes</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
