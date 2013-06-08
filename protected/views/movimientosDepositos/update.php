<?php
$this->breadcrumbs=array(
	'Movimientos Stocks'=>array('index'),
	$model->id=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>'List MovimientosStock', 'url'=>array('index')),
	array('label'=>'Create MovimientosStock', 'url'=>array('create')),
	array('label'=>'View MovimientosStock', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Manage MovimientosStock', 'url'=>array('admin')),
);
?>

<h1>Update MovimientosStock <?php echo $model->id; ?></h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>