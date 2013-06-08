<?php
$this->breadcrumbs=array(
	'Ciudades'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List Ciudades', 'url'=>array('index')),
	array('label'=>'Manage Ciudades', 'url'=>array('admin')),
);
?>

<h1>Create Ciudades</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>