<?php
$this->breadcrumbs=array(
	'Cta Cte Empleadoses'=>array('index'),
	$model->id=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>'List CtaCteEmpleados', 'url'=>array('index')),
	array('label'=>'Create CtaCteEmpleados', 'url'=>array('create')),
	array('label'=>'View CtaCteEmpleados', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Manage CtaCteEmpleados', 'url'=>array('admin')),
);
?>

<h1>Update CtaCteEmpleados <?php echo $model->id; ?></h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>