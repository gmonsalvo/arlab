<?php

$this->menu=array(
	array('label'=>'Listado de Depositos', 'url'=>array('admin')),
);
?>

<h1>Nuevo Deposito</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>