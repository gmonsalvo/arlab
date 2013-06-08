<?php
$this->breadcrumbs=array(
	'Planes'=>array('index'),
	$model->id=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>'List Planes', 'url'=>array('index')),
	array('label'=>'Create Planes', 'url'=>array('create')),
	array('label'=>'View Planes', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Manage Planes', 'url'=>array('admin')),
);
?>

<h1>Update Planes <?php echo $model->id; ?></h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>