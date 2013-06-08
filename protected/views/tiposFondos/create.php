<?php
$this->breadcrumbs=array(
	'Tipos Fondoses'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List TiposFondos', 'url'=>array('index')),
	array('label'=>'Manage TiposFondos', 'url'=>array('admin')),
);
?>

<h1>Create TiposFondos</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>