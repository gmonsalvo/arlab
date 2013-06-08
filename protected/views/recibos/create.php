<?php
$this->breadcrumbs=array(
	'Reciboses'=>array('index'),
	'Create',
);
?>

<h1>Nuevo Recibo</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>