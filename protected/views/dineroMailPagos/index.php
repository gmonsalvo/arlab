<?php
$this->breadcrumbs=array(
	'Dinero Mail Pagoses',
);

$this->menu=array(
	array('label'=>'Create DineroMailPagos', 'url'=>array('create')),
	array('label'=>'Manage DineroMailPagos', 'url'=>array('admin')),
);
?>

<h1>Dinero Mail Pagoses</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
