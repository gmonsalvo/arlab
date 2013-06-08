<?php
$this->breadcrumbs=array(
	'Cambio Plans',
);

$this->menu=array(
	array('label'=>'Create CambioPlan', 'url'=>array('create')),
	array('label'=>'Manage CambioPlan', 'url'=>array('admin')),
);
?>

<h1>Cambio Plans</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
