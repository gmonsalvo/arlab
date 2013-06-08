<?php
$this->breadcrumbs=array(
	'Forma Pago Reciboses'=>array('index'),
	$model->id=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>'List FormaPagoRecibos', 'url'=>array('index')),
	array('label'=>'Create FormaPagoRecibos', 'url'=>array('create')),
	array('label'=>'View FormaPagoRecibos', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Manage FormaPagoRecibos', 'url'=>array('admin')),
);
?>

<h1>Update FormaPagoRecibos <?php echo $model->id; ?></h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>