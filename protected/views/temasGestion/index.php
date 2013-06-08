<?php
$this->breadcrumbs=array(
	'Temas Gestions',
);

$this->menu=array(
	array('label'=>'Create TemasGestion', 'url'=>array('create')),
	array('label'=>'Manage TemasGestion', 'url'=>array('admin')),
);
?>

<h1>Temas Gestions</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
