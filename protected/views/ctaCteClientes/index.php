<?php
$this->breadcrumbs=array(
	'Cta Cte Clientes',
);

$this->menu=array(
	array('label'=>'Create CtaCteClientes', 'url'=>array('create')),
	array('label'=>'Manage CtaCteClientes', 'url'=>array('admin')),
);
?>

<h1>Cta Cte Clientes</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
