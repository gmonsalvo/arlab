<?php
$this->breadcrumbs=array(
	'Servicios Voips',
);

$this->menu=array(
	array('label'=>'Create ServiciosVoip', 'url'=>array('create')),
	array('label'=>'Manage ServiciosVoip', 'url'=>array('admin')),
);
?>

<h1>Servicios Voips</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
