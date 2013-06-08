<?php
$this->breadcrumbs=array(
	'Depositoses'=>array('index'),
	$model->id=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>'List Depositos', 'url'=>array('index')),
	array('label'=>'Create Depositos', 'url'=>array('create')),
	array('label'=>'View Depositos', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Manage Depositos', 'url'=>array('admin')),
);
?>

<h1>Update Depositos <?php echo $model->id; ?></h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>