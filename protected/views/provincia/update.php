<?php
$this->breadcrumbs=array(
	'Provincias'=>array('index'),
	$model->id=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>'List Provincia', 'url'=>array('index')),
	array('label'=>'Create Provincia', 'url'=>array('create')),
	array('label'=>'View Provincia', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Manage Provincia', 'url'=>array('admin')),
);
?>

<h1>Update Provincia <?php echo $model->id; ?></h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>