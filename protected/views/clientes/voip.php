<?php
//ponemos el si y el no en cuenta y orden
$config = array();
$dataProvider = new CArrayDataProvider($rawData=$model->serviciosVoip, $config);

$this->widget('zii.widgets.grid.CGridView', array(
    'dataProvider'=>$dataProvider
    , 'columns'=>array(
        'id'
		,array(        
		      'name'=>'fechaInstalacion',
		      'header'=>'Fecha Instalacion',
		      'value'=>'$data->fechaInstalacion',
		   )
        ,array(        
		      'name'=>'ciudadId',
		      'header'=>'Ciudad',
		      'value'=>'$data->ciudad->nombre',
		   )
		,array(        
		      'name'=>'costoServicio',
		      'header'=>'Costo del Servicio',
		      'value'=>'$data->costoServicio',
		   )
		,array(        
		      'name'=>'costoServicio',
		      'header'=>'Costo final',
		      'value'=>'number_format($data->costoServicio*1.21,2)',
		   )   
		,array(        
		      'name'=>'interno',
		      'header'=>'Interno',
		      'value'=>'$data->interno',
		   )
        ,array(        
		      'name'=>'detalleEquipamiento',
		      'header'=>'Equipamiento Instalado',
		      'value'=>'$data->detalleEquipo',
		   )
		, array(
            'class'=>'CButtonColumn'
            , 'viewButtonUrl'=>'Yii::app()->createUrl("/serviciosVoip/view", array("id"=>$data["id"]))'
            , 'updateButtonUrl'=>'Yii::app()->createUrl("/serviciosVoip/update", array("id"=>$data["id"]))'
            , 'deleteButtonUrl'=>'Yii::app()->createUrl("/serviciosVoip/delete", array("id"=>$data["id"]))'
            )
    )
));
 ?>
