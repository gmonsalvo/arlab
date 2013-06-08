<?php
$this->menu=array(
	array('label'=>'List CambioPlan', 'url'=>array('index')),
	array('label'=>'Manage CambioPlan', 'url'=>array('admin')),
);
?>

<h1>Cambio de Plan (upgrade/downgrade)</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>