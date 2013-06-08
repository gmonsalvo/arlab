<?php
$this->breadcrumbs=array(
	'Reciboses',
);

$this->menu=array(
	array('label'=>'Create Recibos', 'url'=>array('create')),
	array('label'=>'Manage Recibos', 'url'=>array('admin')),
);
?>

<h1>Reciboses</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
