<?php
$this->breadcrumbs=array(
	'Eventoses'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List Eventos', 'url'=>array('index')),
	array('label'=>'Manage Eventos', 'url'=>array('admin')),
);
?>

<h1>Create Eventos</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>