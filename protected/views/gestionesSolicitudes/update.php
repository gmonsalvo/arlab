<?php
$this->breadcrumbs=array(
	'Gestiones Solicitudes'=>array('index'),
	$model->id=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>'List GestionesSolicitudes', 'url'=>array('index')),
	array('label'=>'Create GestionesSolicitudes', 'url'=>array('create')),
	array('label'=>'View GestionesSolicitudes', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Manage GestionesSolicitudes', 'url'=>array('admin')),
);
?>

<h1>Update GestionesSolicitudes <?php echo $model->id; ?></h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>