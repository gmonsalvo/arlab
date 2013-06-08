<?php
$this->breadcrumbs=array(
	'Reciboses'=>array('index'),
	$model->id=>array('view','id'=>$model->id),
	'Update',
);

?>

<h1>Nuevo Recibo</h1>

<?php echo $this->renderPartial('_formUpdate', array('model'=>$model)); ?>