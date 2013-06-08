<?php
$this->breadcrumbs=array(
	'Conceptos Empleadoses'=>array('index'),
	$model->id,
);

$this->menu=array(
	array('label'=>'List ConceptosEmpleados', 'url'=>array('index')),
	array('label'=>'Create ConceptosEmpleados', 'url'=>array('create')),
	array('label'=>'Update ConceptosEmpleados', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Delete ConceptosEmpleados', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage ConceptosEmpleados', 'url'=>array('admin')),
);
?>

<h1>View ConceptosEmpleados #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'nombre',
		'userStamp',
		'timeStamp',
	),
)); ?>
