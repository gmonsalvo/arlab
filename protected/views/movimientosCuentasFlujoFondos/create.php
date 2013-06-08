<?php

$this->menu=array(
	array('label'=>'Volver a Caja Diaria', 'url'=>array('flujoFondos/adminCajaDiaria')),
);
?>

<h1>Pase de Caja</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>