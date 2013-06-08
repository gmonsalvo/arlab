<?php
$this->breadcrumbs=array(
	'Rendiciones'=>array('index'),
	$model->id=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>'List Rendiciones', 'url'=>array('index')),
	array('label'=>'Create Rendiciones', 'url'=>array('create')),
	array('label'=>'View Rendiciones', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Manage Rendiciones', 'url'=>array('admin')),
);
?>

<h1>Update Rendiciones <?php echo $model->id; ?></h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>