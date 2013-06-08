<?php
$this->breadcrumbs=array(
	'Eventoses',
);

$this->menu=array(
	array('label'=>'Create Eventos', 'url'=>array('create')),
	array('label'=>'Manage Eventos', 'url'=>array('admin')),
);
?>

<h1>Eventoses</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
