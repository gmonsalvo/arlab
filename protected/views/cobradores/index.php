<?php
$this->breadcrumbs=array(
	'Cobradores',
);

$this->menu=array(
	array('label'=>'Create Cobradores', 'url'=>array('create')),
	array('label'=>'Manage Cobradores', 'url'=>array('admin')),
);
?>

<h1>Cobradores</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
