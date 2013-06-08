<?php

$this->menu=array(
	array('label'=>'Log de Movimientos', 'url'=>array('admin')),
);
?>

<h1>Nuevo Movimiento de Stock</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>