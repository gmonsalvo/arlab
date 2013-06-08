<?php
$this->menu=array(
	array('label'=>'Volver', 'url'=>array('admin')),
);
$model->tipoMov=$_GET['tipoMov'];
$model->periodo=$_GET['periodo'];
$model->cuentaId=$_GET['cuentaId'];


//echo $model->periodo;
if ($model->tipoMov==1){
	echo "<h3>Movimiento de Ingreso</h3>";
}else{
	echo "<h3>Movimiento de Egreso</h3>";
}

echo $this->renderPartial('_form', array('model'=>$model,'retorno'=>$retorno)); 

?>