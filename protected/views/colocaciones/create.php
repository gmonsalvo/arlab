<?php
$this->breadcrumbs=array(
	'Colocaciones'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List Colocaciones', 'url'=>array('index')),
	array('label'=>'Manage Colocaciones', 'url'=>array('admin')),
);
?>


<?php
$this->beginWidget('zii.widgets.CPortlet', array(
				'title'=>'',
			));
			 echo "<h2><b>Nueva Colocacion</b></h2>";
		    $this->endWidget();
?>

<?php echo $this->renderPartial('_form', array('model'=>$model,'cheques'=>$cheques,'clientes'=>$clientes)); ?>