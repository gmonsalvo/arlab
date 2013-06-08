<?php

$this->menu=array(
	array('label'=>'Listar Temas de Gestion', 'url'=>array('admin')),
	
);
?>

<h1>Nuevo Tema de Gestion</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>