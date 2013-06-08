<?php
$this->breadcrumbs=array(
	'Arqueos Fondoses'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List ArqueosFondos', 'url'=>array('index')),
	array('label'=>'Manage ArqueosFondos', 'url'=>array('admin')),
);
?>

<h1>Create ArqueosFondos</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>