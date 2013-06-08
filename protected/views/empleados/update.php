<?php
$this->breadcrumbs=array(
	'Empleadoses'=>array('index'),
	$model->id=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>'List Empleados', 'url'=>array('index')),
	array('label'=>'Create Empleados', 'url'=>array('create')),
	array('label'=>'View Empleados', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Manage Empleados', 'url'=>array('admin')),
);
?>

<h1>Update Empleados <?php echo $model->id; ?></h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>