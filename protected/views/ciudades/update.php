<?php
$this->breadcrumbs=array(
	'Ciudades'=>array('index'),
	$model->id=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>'List Ciudades', 'url'=>array('index')),
	array('label'=>'Create Ciudades', 'url'=>array('create')),
	array('label'=>'View Ciudades', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Manage Ciudades', 'url'=>array('admin')),
);
?>

<h1>Update Ciudades <?php echo $model->id; ?></h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>