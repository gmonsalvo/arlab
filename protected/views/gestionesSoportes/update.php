<?php
$this->breadcrumbs=array(
	'Gestiones Soportes'=>array('index'),
	$model->id=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>'List GestionesSoportes', 'url'=>array('index')),
	array('label'=>'Create GestionesSoportes', 'url'=>array('create')),
	array('label'=>'View GestionesSoportes', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Manage GestionesSoportes', 'url'=>array('admin')),
);
?>

<h1>Update GestionesSoportes <?php echo $model->id; ?></h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>