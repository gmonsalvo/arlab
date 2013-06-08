<?php
$this->breadcrumbs=array(
	'Cicloses'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List Ciclos', 'url'=>array('index')),
	array('label'=>'Manage Ciclos', 'url'=>array('admin')),
);
?>

<h1>Create Ciclos</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>