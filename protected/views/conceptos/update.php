<?php
$this->breadcrumbs=array(
	'Conceptoses'=>array('index'),
	$model->id=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>'List Conceptos', 'url'=>array('index')),
	array('label'=>'Create Conceptos', 'url'=>array('create')),
	array('label'=>'View Conceptos', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Manage Conceptos', 'url'=>array('admin')),
);
?>

<h1>Update Conceptos <?php echo $model->id; ?></h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>