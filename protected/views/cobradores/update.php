<?php
$this->breadcrumbs=array(
	'Cobradores'=>array('index'),
	$model->id=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>'List Cobradores', 'url'=>array('index')),
	array('label'=>'Create Cobradores', 'url'=>array('create')),
	array('label'=>'View Cobradores', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Manage Cobradores', 'url'=>array('admin')),
);
?>

<h1>Update Cobradores <?php echo $model->id; ?></h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>