<?php
$this->breadcrumbs=array(
	'Tipo Libroses'=>array('index'),
	$model->id=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>'List TipoLibros', 'url'=>array('index')),
	array('label'=>'Create TipoLibros', 'url'=>array('create')),
	array('label'=>'View TipoLibros', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Manage TipoLibros', 'url'=>array('admin')),
);
?>

<h1>Update TipoLibros <?php echo $model->id; ?></h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>