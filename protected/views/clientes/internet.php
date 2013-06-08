<?php
//ponemos el si y el no en cuenta y orden
$config = array();
$dataProvider = new CArrayDataProvider($rawData=$model->serviciosInternets, $config);

$this->widget('zii.widgets.grid.CGridView', array(
    'dataProvider'=>$dataProvider
    , 'columns'=>array(
        'id'
		,array(        
		      'name'=>'fecha_instalacion',
		      'header'=>'Fecha Instalacion',
		      'value'=>'$data->fecha_instalacion',
		   )
		 ,array(        
		      'name'=>'domicilio',
		      'header'=>'domicilio',
		      'value'=>'$data->domicilio',
		   )  
        ,array(        
		      'name'=>'ciudadId',
		      'header'=>'Ciudad',
		      'value'=>'$data->ciudad->nombre',
		   )
		,array(        
		      'name'=>'costoServicio',
		      'header'=>'Costo final',
		      'value'=>'number_format($data->costoServicio*1.21,2)',
		   )   
		,array(        
		      'name'=>'anchoBanda',
		      'header'=>'Plan',
		      'value'=>'$data->plan->descripcion',
		   )
        ,array(        
		      'name'=>'detalle_equipamiento',
		      'header'=>'Equipamiento Instalado',
		      'value'=>'$data->equipo->descripcion',
		   )
        ,array(        
		      'name'=>'ip_antena',
		      'header'=>'IP Antena',
		      'value'=>'$data->ip_antena',
		   )
        
		, array(
            'class'=>'CButtonColumn'
            , 'viewButtonUrl'=>'Yii::app()->createUrl("/serviciosInternet/view", array("id"=>$data["id"]))'
            , 'updateButtonUrl'=>'Yii::app()->createUrl("/serviciosInternet/update", array("id"=>$data["id"]))'
            , 'deleteButtonUrl'=>'Yii::app()->createUrl("/serviciosInternet/delete", array("id"=>$data["id"]))'
            )
    )
));
 ?>
