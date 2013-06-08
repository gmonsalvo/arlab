<?php
$this->breadcrumbs=array(
	'Conceptos Empleadoses'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List ConceptosEmpleados', 'url'=>array('index')),
	array('label'=>'Manage ConceptosEmpleados', 'url'=>array('admin')),
);
?>

<h1>Create ConceptosEmpleados</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>