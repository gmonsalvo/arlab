<?php
$this->breadcrumbs=array(
	'Planes'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List Planes', 'url'=>array('index')),
	array('label'=>'Manage Planes', 'url'=>array('admin')),
);
?>

<h1>Create Planes</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>