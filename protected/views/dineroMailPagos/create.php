<?php
$this->breadcrumbs=array(
	'Dinero Mail Pagoses'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List DineroMailPagos', 'url'=>array('index')),
	array('label'=>'Manage DineroMailPagos', 'url'=>array('admin')),
);
?>

<h1>Create DineroMailPagos</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>