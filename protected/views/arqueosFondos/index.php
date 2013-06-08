<?php
$this->breadcrumbs=array(
	'Arqueos Fondoses',
);

$this->menu=array(
	array('label'=>'Create ArqueosFondos', 'url'=>array('create')),
	array('label'=>'Manage ArqueosFondos', 'url'=>array('admin')),
);
?>

<h1>Arqueos Fondoses</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
