<?php
$this->breadcrumbs=array(
	'Facturases'=>array('index'),
	$model->id=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>'List Facturas', 'url'=>array('index')),
	array('label'=>'Create Facturas', 'url'=>array('create')),
	array('label'=>'View Facturas', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Manage Facturas', 'url'=>array('admin')),
);
?>

<h1>Update Facturas <?php echo $model->id; ?></h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>