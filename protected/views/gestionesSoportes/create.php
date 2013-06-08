<?php
$this->breadcrumbs=array(
	'Gestiones Soportes'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List GestionesSoportes', 'url'=>array('index')),
	array('label'=>'Manage GestionesSoportes', 'url'=>array('admin')),
);
?>

<h1>Create GestionesSoportes</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>