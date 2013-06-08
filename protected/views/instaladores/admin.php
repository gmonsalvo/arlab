<?php
$this->menu=array(
	array('label'=>'Nuevo Grupo de Instalacion', 'url'=>array('create')),
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$.fn.yiiGridView.update('instaladores-grid', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<h1>Administracion de grupo de Instalacion</h1>


<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'instaladores-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'columns'=>array(
		'id',
		'descripcion',
		'depositoId',
		array(
			'class'=>'CButtonColumn',
		),
	),
)); ?>
