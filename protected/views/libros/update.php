<?php
$this->breadcrumbs=array(
	'Libroses'=>array('index'),
	$model->id=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>'List Libros', 'url'=>array('index')),
	array('label'=>'Create Libros', 'url'=>array('create')),
	array('label'=>'View Libros', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Manage Libros', 'url'=>array('admin')),
);
?>

<h1>Update Libros <?php echo $model->id; ?></h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>