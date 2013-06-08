<?php
$this->breadcrumbs=array(
	'Gestiones Administracions'=>array('index'),
	'Create',
);
/*
$this->menu=array(
	array('label'=>'List GestionesAdministracion', 'url'=>array('index')),
	array('label'=>'Manage GestionesAdministracion', 'url'=>array('admin')),
);
*/
?>

<h1>Nueva Gestion</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>
