<?php
$this->breadcrumbs=array(
	'Tipo Gestiones',
);

$this->menu=array(
	array('label'=>'Create TipoGestiones', 'url'=>array('create')),
	array('label'=>'Manage TipoGestiones', 'url'=>array('admin')),
);
?>

<h1>Tipo Gestiones</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
