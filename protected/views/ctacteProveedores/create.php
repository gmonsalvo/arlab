<?php
$this->breadcrumbs=array(
	'Ctacte Proveedores'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List CtacteProveedores', 'url'=>array('index')),
	array('label'=>'Manage CtacteProveedores', 'url'=>array('admin')),
);
?>

<h1>Create CtacteProveedores</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>