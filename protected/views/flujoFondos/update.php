<?php
$this->breadcrumbs=array(
	'Flujo Fondoses'=>array('index'),
	$model->id=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>'List FlujoFondos', 'url'=>array('index')),
	array('label'=>'Create FlujoFondos', 'url'=>array('create')),
	array('label'=>'View FlujoFondos', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Manage FlujoFondos', 'url'=>array('admin')),
);
?>

<h1>Update FlujoFondos <?php echo $model->id; ?></h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>