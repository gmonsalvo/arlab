<?php


$this->menu=array(
	array('label'=>'Listar Equipos', 'url'=>array('admin')),
	array('label'=>'Nuevo Equipo', 'url'=>array('create')),
	
);
?>

<h1>Update Equipos <?php echo $model->id; ?></h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>