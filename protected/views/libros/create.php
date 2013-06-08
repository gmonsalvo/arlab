<?php
$this->breadcrumbs=array(
	'Libroses'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List Libros', 'url'=>array('index')),
	array('label'=>'Manage Libros', 'url'=>array('admin')),
);
?>

<h1>Create Libros</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>