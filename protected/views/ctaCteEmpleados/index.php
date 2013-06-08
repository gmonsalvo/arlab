<?php
$this->breadcrumbs=array(
	'Cta Cte Empleadoses',
);

$this->menu=array(
	array('label'=>'Create CtaCteEmpleados', 'url'=>array('create')),
	array('label'=>'Manage CtaCteEmpleados', 'url'=>array('admin')),
);
?>

<h1>Cta Cte Empleadoses</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
