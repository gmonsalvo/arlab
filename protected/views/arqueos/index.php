<?php
$this->breadcrumbs=array(
	'Arqueoses',
);

$this->menu=array(
	array('label'=>'Create Arqueos', 'url'=>array('create')),
	array('label'=>'Manage Arqueos', 'url'=>array('admin')),
);
?>

<h1>Arqueoses</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
