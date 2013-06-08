<?php
$this->breadcrumbs=array(
	'Instaladores',
);

$this->menu=array(
	array('label'=>'Create Instaladores', 'url'=>array('create')),
	array('label'=>'Manage Instaladores', 'url'=>array('admin')),
);
?>

<h1>Instaladores</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
