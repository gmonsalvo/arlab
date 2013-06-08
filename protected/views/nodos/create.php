<?php
$this->breadcrumbs=array(
	'Nodoses'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List Nodos', 'url'=>array('index')),
	array('label'=>'Manage Nodos', 'url'=>array('admin')),
);
?>

<h1>Create Nodos</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>