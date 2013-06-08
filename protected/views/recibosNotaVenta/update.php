<?php
$this->breadcrumbs=array(
	'Recibos Nota Ventas'=>array('index'),
	$model->id=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>'List RecibosNotaVenta', 'url'=>array('index')),
	array('label'=>'Create RecibosNotaVenta', 'url'=>array('create')),
	array('label'=>'View RecibosNotaVenta', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Manage RecibosNotaVenta', 'url'=>array('admin')),
);
?>

<h1>Update RecibosNotaVenta <?php echo $model->id; ?></h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>