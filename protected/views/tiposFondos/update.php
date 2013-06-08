<?php
$this->breadcrumbs=array(
	'Tipos Fondoses'=>array('index'),
	$model->id=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>'List TiposFondos', 'url'=>array('index')),
	array('label'=>'Create TiposFondos', 'url'=>array('create')),
	array('label'=>'View TiposFondos', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Manage TiposFondos', 'url'=>array('admin')),
);
?>

<h1>Update TiposFondos <?php echo $model->id; ?></h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>