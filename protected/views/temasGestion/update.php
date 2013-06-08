<?php
$this->breadcrumbs=array(
	'Temas Gestions'=>array('index'),
	$model->id=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>'List TemasGestion', 'url'=>array('index')),
	array('label'=>'Create TemasGestion', 'url'=>array('create')),
	array('label'=>'View TemasGestion', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Manage TemasGestion', 'url'=>array('admin')),
);
?>

<h1>Update TemasGestion <?php echo $model->id; ?></h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>