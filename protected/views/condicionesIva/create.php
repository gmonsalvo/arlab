<?php
$this->breadcrumbs=array(
	'Condiciones Ivas'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List CondicionesIva', 'url'=>array('index')),
	array('label'=>'Manage CondicionesIva', 'url'=>array('admin')),
);
?>

<h1>Create CondicionesIva</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>