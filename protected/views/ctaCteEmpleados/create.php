<?php


$this->menu=array(
	array('label'=>'CtaCte Empleados', 'url'=>array('admin')),
	array('label'=>'Agregar Honorario', 'url'=>array('createHonorario')),
	array('label'=>'Agregar Pago', 'url'=>array('createPago')),
);
?>

<h1>Nuevo Movimiento CtaCte Empleados</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>