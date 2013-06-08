<?php
$this->breadcrumbs=array(
	'Tipo Libroses'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List TipoLibros', 'url'=>array('index')),
	array('label'=>'Manage TipoLibros', 'url'=>array('admin')),
);
?>

<h1>Create TipoLibros</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>