<?php
//obtenemos el objeto cliente apartir del id pasado en el get 
 
$cliente=Clientes::model()->findByPk(Yii::app()->user->model->username);
//Filtramos los movimientos en cuenta corriente del cliente actual
?>

<h3>
		<?php echo "<b>Saldo Actual:</b> $".number_format($cliente->getSaldo(),2); ?>
</h3>
</br>
<h3>Detalle de Movimientos</h3>
<?php 

  $criteria = new CDbCriteria;
  $criteria->select = 't.*';
  $criteria->join  =' INNER JOIN notaVenta nv ON nv.id = t.notaVentaId';
  $criteria->condition = ' nv.clienteId = :value';
  $criteria->params = array(":value" =>$cliente->id );
  $criteria->order= "periodo,tipoMov,fecha";
  /*$criteria = new CDbCriteria();
  
  $criteria->condition="clienteId=".$cliente->id; 
*/
//$ctacte=NotaVenta::model()->findAll($criteria);
//print_r($ctacte);
	
  $dataProvider=new CActiveDataProvider($model, array(
    'criteria'=>$criteria,
    'pagination'=>array(
        'pageSize'=>50,
    ),
));


$this->widget('GridViewStyle', array(
	'id'=>'cta-cte-clientes-grid',
	'rowCssStyleExpression'=>'$data->tipoMov == 0 ? "background-color: #e6f1f5" : "background-color:#b9dd94"',
	'dataProvider'=>$dataProvider,
	'columns'=>array(
	'id',
	array(
		'name'=>'fecha',
		'header'=>'fecha',
		'value'=>'$data->fecha',
                ),
        array(
		'name'=>'fechaVecimiento',
		'header'=>'fechaVencimiento',
		'value'=>'$data->notaVenta->fechaVencimiento',
                
                ),    
         array(
		'name'=>'periodo',
		'header'=>'periodo',
		'value'=>'$data->notaVenta->periodo',
		),        
     array(
		'name'=>'NotaVentaId',
		'header'=>'NotaVenta',
		'value'=>'$data->notaVentaId',
		),             
	array(
		'name'=>'tipoMov',
		'header'=>'Tipo Mov',
		'value'=>'$data->getTypeDescription()',
		),
	array(
		'name'=>'concepto',
		'header'=>'Concepto',
		'value'=>'$data->concepto->nombre',
	),
	array(
		'name'=>'detalle',
		'header'=>'Detalle',
		'value'=>'$data->tipoMov==0 ? $data->notaVenta->detalle:""',
	),
	
	array(
		'name'=>'monto',
		'type'=>'ntext',
		'header'=>'Monto',
		'value'=>'number_format($data->monto,2)',
                'htmlOptions'=>array('style'=>'text-align: right'),
	),
	 
	),
)); 

?>
<div class="row">
		<?php echo "<b>Saldo Actual:</b> $".number_format($cliente->getSaldo(),2); ?>
</div>