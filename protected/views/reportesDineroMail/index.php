<?php
$this->breadcrumbs=array(
	'Reportes Dinero Mails',
);

$this->menu=array(
	array('label'=>'Create ReportesDineroMail', 'url'=>array('create')),
	array('label'=>'Manage ReportesDineroMail', 'url'=>array('admin')),
);
?>

<h1>Reportes Dinero Mails</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
