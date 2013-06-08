<?php
$this->breadcrumbs=array(
	'Tipo Libroses',
);

$this->menu=array(
	array('label'=>'Create TipoLibros', 'url'=>array('create')),
	array('label'=>'Manage TipoLibros', 'url'=>array('admin')),
);
?>

<h1>Tipo Libroses</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
