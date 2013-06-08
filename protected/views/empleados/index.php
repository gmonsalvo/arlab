<?php
$this->breadcrumbs=array(
	'Empleadoses',
);

$this->menu=array(
	array('label'=>'Create Empleados', 'url'=>array('create')),
	array('label'=>'Manage Empleados', 'url'=>array('admin')),
);
?>

<h1>Empleadoses</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
