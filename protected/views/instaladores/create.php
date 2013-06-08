<?php
$this->breadcrumbs=array(
	'Instaladores'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List Instaladores', 'url'=>array('index')),
	array('label'=>'Manage Instaladores', 'url'=>array('admin')),
);
?>

<h1>Create Instaladores</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>