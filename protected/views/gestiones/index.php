<?php
$this->breadcrumbs=array(
	'Gestiones',
);

$this->menu=array(
	array('label'=>'Create Gestiones', 'url'=>array('create')),
	array('label'=>'Manage Gestiones', 'url'=>array('admin')),
);
?>

<h1>Gestiones</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
