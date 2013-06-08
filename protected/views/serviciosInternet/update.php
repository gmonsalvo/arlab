<?php
$this->breadcrumbs=array(
	'Servicios Internets'=>array('index'),
	$model->id=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>'List ServiciosInternet', 'url'=>array('index')),
	array('label'=>'Create ServiciosInternet', 'url'=>array('create')),
	array('label'=>'View ServiciosInternet', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Manage ServiciosInternet', 'url'=>array('admin')),
);
?>

<h1>Update ServiciosInternet <?php echo $model->id; ?></h1>

<?php echo $this->renderPartial('_formUpdate', array('model'=>$model)); ?>