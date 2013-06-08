<?php
$this->breadcrumbs=array(
	'Tipos Fondoses',
);

$this->menu=array(
	array('label'=>'Create TiposFondos', 'url'=>array('create')),
	array('label'=>'Manage TiposFondos', 'url'=>array('admin')),
);
?>

<h1>Tipos Fondoses</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
