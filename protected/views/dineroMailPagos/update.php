<?php
$this->breadcrumbs=array(
	'Dinero Mail Pagoses'=>array('index'),
	$model->id=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>'List DineroMailPagos', 'url'=>array('index')),
	array('label'=>'Create DineroMailPagos', 'url'=>array('create')),
	array('label'=>'View DineroMailPagos', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Manage DineroMailPagos', 'url'=>array('admin')),
);
?>

<h1>Update DineroMailPagos <?php echo $model->id; ?></h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>