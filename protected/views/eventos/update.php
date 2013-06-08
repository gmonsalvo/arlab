<?php
$this->breadcrumbs=array(
	'Eventoses'=>array('index'),
	$model->id=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>'List Eventos', 'url'=>array('index')),
	array('label'=>'Create Eventos', 'url'=>array('create')),
	array('label'=>'View Eventos', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Manage Eventos', 'url'=>array('admin')),
);
?>

<h1>Update Eventos <?php echo $model->id; ?></h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>