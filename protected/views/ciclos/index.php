<?php
$this->breadcrumbs=array(
	'Cicloses',
);

$this->menu=array(
	array('label'=>'Create Ciclos', 'url'=>array('create')),
	array('label'=>'Manage Ciclos', 'url'=>array('admin')),
);
?>

<h1>Cicloses</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
