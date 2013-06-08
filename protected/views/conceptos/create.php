<?php
$this->breadcrumbs=array(
	'Conceptoses'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List Conceptos', 'url'=>array('index')),
	array('label'=>'Manage Conceptos', 'url'=>array('admin')),
);
?>

<h1>Create Conceptos</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>