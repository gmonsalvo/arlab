<?php
$this->breadcrumbs=array(
	'Arqueos Fondoses'=>array('index'),
	$model->id=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>'List ArqueosFondos', 'url'=>array('index')),
	array('label'=>'Create ArqueosFondos', 'url'=>array('create')),
	array('label'=>'View ArqueosFondos', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Manage ArqueosFondos', 'url'=>array('admin')),
);
?>

<h1>Update ArqueosFondos <?php echo $model->id; ?></h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>