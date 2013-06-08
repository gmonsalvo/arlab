<?php
$this->breadcrumbs=array(
	'Cta Cte Clientes'=>array('index'),
	$model->id=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>'List CtaCteClientes', 'url'=>array('index')),
	array('label'=>'Create CtaCteClientes', 'url'=>array('create')),
	array('label'=>'View CtaCteClientes', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Manage CtaCteClientes', 'url'=>array('admin')),
);
?>

<h1>Update CtaCteClientes <?php echo $model->id; ?></h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>