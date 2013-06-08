<?php
$this->breadcrumbs=array(
	'Gestiones'=>array('index'),
	$model->id=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>'List Gestiones', 'url'=>array('index')),
	array('label'=>'Create Gestiones', 'url'=>array('create')),
	array('label'=>'View Gestiones', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Manage Gestiones', 'url'=>array('admin')),
);
?>

<h1>Update Gestiones <?php echo $model->id; ?></h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>