<?php
$this->breadcrumbs=array(
	'Tipo Gestiones'=>array('index'),
	$model->id=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>'List TipoGestiones', 'url'=>array('index')),
	array('label'=>'Create TipoGestiones', 'url'=>array('create')),
	array('label'=>'View TipoGestiones', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Manage TipoGestiones', 'url'=>array('admin')),
);
?>

<h1>Update TipoGestiones <?php echo $model->id; ?></h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>