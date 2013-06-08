<?php
$this->breadcrumbs=array(
	'Nota Ventas'=>array('index'),
	$model->id=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>'List NotaVenta', 'url'=>array('index')),
	array('label'=>'Create NotaVenta', 'url'=>array('create')),
	array('label'=>'View NotaVenta', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Manage NotaVenta', 'url'=>array('admin')),
);
?>

<h1>Update NotaVenta <?php echo $model->id; ?></h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>