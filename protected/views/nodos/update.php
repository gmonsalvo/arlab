<?php
$this->breadcrumbs=array(
	'Nodoses'=>array('index'),
	$model->id=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>'List Nodos', 'url'=>array('index')),
	array('label'=>'Create Nodos', 'url'=>array('create')),
	array('label'=>'View Nodos', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Manage Nodos', 'url'=>array('admin')),
);
?>

<h1>Update Nodos <?php echo $model->id; ?></h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>