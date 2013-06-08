<?php
$this->breadcrumbs=array(
	'Barrioses'=>array('index'),
	$model->id=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>'List Barrios', 'url'=>array('index')),
	array('label'=>'Create Barrios', 'url'=>array('create')),
	array('label'=>'View Barrios', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Manage Barrios', 'url'=>array('admin')),
);
?>

<h1>Update Barrios <?php echo $model->id; ?></h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>