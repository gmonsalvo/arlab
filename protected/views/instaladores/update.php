<?php
$this->breadcrumbs=array(
	'Instaladores'=>array('index'),
	$model->id=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>'List Instaladores', 'url'=>array('index')),
	array('label'=>'Create Instaladores', 'url'=>array('create')),
	array('label'=>'View Instaladores', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Manage Instaladores', 'url'=>array('admin')),
);
?>

<h1>Update Instaladores <?php echo $model->id; ?></h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>