<?php
$this->breadcrumbs=array(
	'Pagos Electronicoses',
);

$this->menu=array(
	array('label'=>'Create PagosElectronicos', 'url'=>array('create')),
	array('label'=>'Manage PagosElectronicos', 'url'=>array('admin')),
);
?>

<h1>Pagos Electronicoses</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
