<?php
$this->breadcrumbs=array(
	'Gestiones Solicitudes'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List GestionesSolicitudes', 'url'=>array('index')),
	array('label'=>'Manage GestionesSolicitudes', 'url'=>array('admin')),
);
?>

<h1>Create GestionesSolicitudes</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>