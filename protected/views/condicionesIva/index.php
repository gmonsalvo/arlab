<?php
$this->breadcrumbs=array(
	'Condiciones Ivas',
);

$this->menu=array(
	array('label'=>'Create CondicionesIva', 'url'=>array('create')),
	array('label'=>'Manage CondicionesIva', 'url'=>array('admin')),
);
?>

<h1>Condiciones Ivas</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
