<?php
$this->breadcrumbs=array(
	'Depositoses',
);

$this->menu=array(
	array('label'=>'Create Depositos', 'url'=>array('create')),
	array('label'=>'Manage Depositos', 'url'=>array('admin')),
);
?>

<h1>Depositoses</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
