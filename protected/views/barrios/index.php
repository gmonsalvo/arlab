<?php
$this->breadcrumbs=array(
	'Barrioses',
);

$this->menu=array(
	array('label'=>'Create Barrios', 'url'=>array('create')),
	array('label'=>'Manage Barrios', 'url'=>array('admin')),
);
?>

<h1>Barrioses</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
