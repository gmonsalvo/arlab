<?php
$this->breadcrumbs=array(
	'Proveedores'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'Listar Proveedores', 'url'=>array('admin')),
	
);
?>

<h1>Nuevo Proveedo</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>