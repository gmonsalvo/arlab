<?php

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$.fn.yiiGridView.update('flujo-fondos-grid', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<h1>Reporte por Conceptos</h1>

<div class="search-form">
<?php $this->renderPartial('_searchConceptos',array(
	'model'=>$model,
)); ?>
</div><!-- search-form -->
<?php 
$this->widget('zii.widgets.grid.CGridView', array(
    'id'=>'flujo-fondos-grid',
    'ajaxUpdate'=>'false',
    //'filter'=>$model,
    'dataProvider'=>$model->searchConceptos(),
    'columns'=>array(
        'id',
        'fecha',
        array(        
              'name'=>'tipoFondoId',
              'header'=>'TipoFondo',
              'value'=>'$data->tipoFondo->nombre',
           ),

        array(        
              'name'=>'descripcion',
              'header'=>'Descripcion',
              'type'=>'html',
              'value'=>'$data->descripcion',
           ),
        'userStamp',
        array(
          'name'=>'Monto',
          'value'=>'$data->monto',
          'htmlOptions'=>array('style' => 'text-align: right;'),
          'type'=>'text',
          'footer'=>$model->searchConceptos()->itemCount===0 ? '' : $model->getTotals(),
),

    ),
)); ?>

