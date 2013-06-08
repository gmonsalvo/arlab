<?php
$this->breadcrumbs=array(
	'Cobradores'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List Cobradores', 'url'=>array('index')),
	array('label'=>'Manage Cobradores', 'url'=>array('admin')),
);
?>

<h1>Create Cobradores</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>