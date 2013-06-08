<?php
$this->breadcrumbs=array(
	'Rendiciones',
);

$this->menu=array(
	array('label'=>'Create Rendiciones', 'url'=>array('create')),
	array('label'=>'Manage Rendiciones', 'url'=>array('admin')),
);
?>

<h1>Rendiciones</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
