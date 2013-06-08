<?php
$this->breadcrumbs=array(
	'Formas Pagos'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List FormasPago', 'url'=>array('index')),
	array('label'=>'Manage FormasPago', 'url'=>array('admin')),
);
?>

<h1>Create FormasPago</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>