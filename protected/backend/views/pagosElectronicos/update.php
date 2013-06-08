<?php
$this->breadcrumbs=array(
	'Pagos Electronicoses'=>array('index'),
	$model->id=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>'List PagosElectronicos', 'url'=>array('index')),
	array('label'=>'Create PagosElectronicos', 'url'=>array('create')),
	array('label'=>'View PagosElectronicos', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Manage PagosElectronicos', 'url'=>array('admin')),
);
?>

<h1>Update PagosElectronicos <?php echo $model->id; ?></h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>