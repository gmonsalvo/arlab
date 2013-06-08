<?php
$this->breadcrumbs=array(
	'Flujo Fondoses',
);

$this->menu=array(
	array('label'=>'Create FlujoFondos', 'url'=>array('create')),
	array('label'=>'Manage FlujoFondos', 'url'=>array('admin')),
);
?>

<h1>Flujo Fondoses</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
