<?php
$this->breadcrumbs=array(
	'Rendiciones'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List Rendiciones', 'url'=>array('index')),
	array('label'=>'Manage Rendiciones', 'url'=>array('admin')),
);
?>

<h1>Create Rendiciones</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>