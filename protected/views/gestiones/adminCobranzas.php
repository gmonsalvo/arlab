
<h1>Gestion de Cobranzas</h1>


<?php 

$this->widget('GridViewStyle', array(
	'id'=>'gestiones-grid',
	'dataProvider'=>$model->searchCobranzas(),
        'rowCssStyleExpression'=>'( strtotime(date("Y-m-d"))-strtotime($data->fecha))/(60 * 60 * 24)>=2 ? "background-color: #efacad" : "background-color:#f8f8f8"',
	'filter'=>$model,
	'columns'=>array(
		'id',
                'fecha',
                 array(        
		      'name'=>'diasGestion',
		      'header'=>'Dias de Gestion',
		      'value'=>'( strtotime(date("Y-m-d"))-strtotime($data->fecha))/(60 * 60 * 24)',
		   ), 
                 array(        
		      'name'=>'clienteId',
		      'header'=>'Cliente',
		      'value'=>'$data->cliente->razonSocial',
                       'filter'=>  CHtml::listData(Clientes::model()->findAll(), 'id', 'razonSocial'),  
		   ),
                array(        
		      'name'=>'ciudadCliente', 
		      'header'=>'Ciudad Cliente',
		      'value'=>'$data->cliente->ciudad->nombre',
                      'filter'=>  CHtml::listData(Ciudades::model()->findAll(), 'id', 'nombre'),  
		   ),
                array(        
		      'name'=>'direccionCliente', 
		      'header'=>'Domicilio Cliente',
		      'value'=>'$data->cliente->direccion',
                       
		   ),
               
		array(        
		      'name'=>'temaId',
		      'header'=>'Tema',
		      'value'=>'$data->tema->descripcion',
                      'filter'=>CHtml::listData(TemasGestion::model()->findAll("tipoGestionId=1"),'id','descripcion'),
		   ),
		'detalle',
		
		array(        
		      'name'=>'estado',
		      'header'=>'Estado',
		      'value'=>'$data->estado==0 ? "Abierto":"Cerrado"',
		   ),
		array(        
		      'name'=>'usuarioResponsable',
		      'header'=>'Usuario Responsable',
		      'value'=>'$data->usuario->username',
                      'filter'=>  CHtml::listData(User::model()->findAll(), 'id', 'username'),  
		   ),
		
		 array(        
		      'name'=>'id',
		      'header'=>'Accion',
		      'value'=>'CHtml::link("Ver",Yii::app()->createUrl("gestiones/view", array("id"=>$data["id"])),array("target"=>"_blank"))',
                      'type'=>'raw',
             	    ),
	),
)); 

?>
