<?php
$this->breadcrumbs=array(
	'Nodoses',
);

$this->menu=array(
	array('label'=>'Create Nodos', 'url'=>array('create')),
	array('label'=>'Manage Nodos', 'url'=>array('admin')),
);
?>

<h1>Nodoses</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
