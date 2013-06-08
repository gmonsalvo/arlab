<?php
$this->breadcrumbs=array(
	'Libroses',
);

$this->menu=array(
	array('label'=>'Create Libros', 'url'=>array('create')),
	array('label'=>'Manage Libros', 'url'=>array('admin')),
);
?>

<h1>Libroses</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
