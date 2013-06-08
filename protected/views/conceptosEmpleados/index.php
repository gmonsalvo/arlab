<?php
$this->breadcrumbs=array(
	'Conceptos Empleadoses',
);

$this->menu=array(
	array('label'=>'Create ConceptosEmpleados', 'url'=>array('create')),
	array('label'=>'Manage ConceptosEmpleados', 'url'=>array('admin')),
);
?>

<h1>Conceptos Empleadoses</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
