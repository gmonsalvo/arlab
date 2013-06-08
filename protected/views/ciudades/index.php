<?php
$this->breadcrumbs=array(
	'Ciudades',
);

$this->menu=array(
	array('label'=>'Create Ciudades', 'url'=>array('create')),
	array('label'=>'Manage Ciudades', 'url'=>array('admin')),
);
?>

<h1>Ciudades</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
