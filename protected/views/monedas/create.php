<?php
$this->breadcrumbs=array(
	'Monedases'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List Monedas', 'url'=>array('index')),
	array('label'=>'Manage Monedas', 'url'=>array('admin')),
);
?>

<h1>Create Monedas</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>