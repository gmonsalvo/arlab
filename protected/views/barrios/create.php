<?php
$this->breadcrumbs=array(
	'Barrioses'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List Barrios', 'url'=>array('index')),
	array('label'=>'Manage Barrios', 'url'=>array('admin')),
);
?>

<h1>Create Barrios</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>