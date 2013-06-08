<?php
$this->breadcrumbs=array(
	'Condiciones Ivas'=>array('index'),
	$model->id=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>'List CondicionesIva', 'url'=>array('index')),
	array('label'=>'Create CondicionesIva', 'url'=>array('create')),
	array('label'=>'View CondicionesIva', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Manage CondicionesIva', 'url'=>array('admin')),
);
?>

<h1>Update CondicionesIva <?php echo $model->id; ?></h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>