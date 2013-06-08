<?php

$this->menu=array(
	array('label'=>'Volver a la hoja del cliente', 'url'=>array('/clientes/view','id'=>$_GET['clienteId'])),
);
?>

<h1>Nuevo servicio de VOIP</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>
