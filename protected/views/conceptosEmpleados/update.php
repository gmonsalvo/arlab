<?php
$this->breadcrumbs=array(
	'Conceptos Empleadoses'=>array('index'),
	$model->id=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>'List ConceptosEmpleados', 'url'=>array('index')),
	array('label'=>'Create ConceptosEmpleados', 'url'=>array('create')),
	array('label'=>'View ConceptosEmpleados', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Manage ConceptosEmpleados', 'url'=>array('admin')),
);
?>

<h1>Update ConceptosEmpleados <?php echo $model->id; ?></h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>