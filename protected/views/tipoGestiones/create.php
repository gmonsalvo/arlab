<?php
$this->breadcrumbs=array(
	'Tipo Gestiones'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List TipoGestiones', 'url'=>array('index')),
	array('label'=>'Manage TipoGestiones', 'url'=>array('admin')),
);
?>

<h1>Create TipoGestiones</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>