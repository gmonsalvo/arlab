<?php
$this->breadcrumbs=array(
	'Gestiones Administracions'=>array('index'),
	$model->id=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>'List GestionesAdministracion', 'url'=>array('index')),
	array('label'=>'Create GestionesAdministracion', 'url'=>array('create')),
	array('label'=>'View GestionesAdministracion', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Manage GestionesAdministracion', 'url'=>array('admin')),
);
?>

<h1>Update GestionesAdministracion <?php echo $model->id; ?></h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>