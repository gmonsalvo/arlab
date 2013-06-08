<?php
$this->breadcrumbs=array(
	'Cicloses'=>array('index'),
	$model->id=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>'List Ciclos', 'url'=>array('index')),
	array('label'=>'Create Ciclos', 'url'=>array('create')),
	array('label'=>'View Ciclos', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Manage Ciclos', 'url'=>array('admin')),
);
?>

<h1>Update Ciclos <?php echo $model->id; ?></h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>