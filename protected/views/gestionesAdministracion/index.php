<?php
$this->breadcrumbs=array(
	'Gestiones Administracions',
);

$this->menu=array(
	array('label'=>'Create GestionesAdministracion', 'url'=>array('create')),
	array('label'=>'Manage GestionesAdministracion', 'url'=>array('admin')),
);
?>

<h1>Gestiones Administracions</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
