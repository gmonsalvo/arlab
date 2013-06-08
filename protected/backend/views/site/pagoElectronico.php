<?php
//obtenemos el objeto cliente apartir del id pasado en el get 
 
$cliente=Clientes::model()->findByPk(Yii::app()->user->model->username);
//Filtramos los movimientos en cuenta corriente del cliente actual
?>
<div align=center>
<h3>
		<?php echo "<b>Saldo Actual:</b> $".number_format($cliente->getSaldo(),2); ?>
</h3>
</br>
<h3>
		<?php echo "Ingrese el Monto a Abonar:"; ?>
</h3>


<form action='https://argentina.dineromail.com/Shop/Shop_Ingreso.asp' method='post'>
		<input type='hidden' name='NombreItem' value='Abono Mensual'>
		<input type='hidden' name='TipoMoneda' value='1'>
		<input type='hidden' name='transaction_id' value='<?php echo Yii::app()->user->model->username?>'>
		
		<input type='textbox' name='PrecioItem' value=''></br></br>
		<input type='hidden' name='E_Comercio' value='34317'>
		<input type='hidden' name='NroItem' value='-'>
		<input type='hidden' name='image_url' value='http://'>
		<input type='hidden' name='DireccionExito' value='http://devel.arlab.com.ar/backend.php/site/exito'>
		<input type='hidden' name='DireccionFracaso' value='http://devel.arlab.com.ar/backend.php/site/fracaso'>
		<input type='hidden' name='DireccionEnvio' value='1'>
		<input type='hidden' name='Mensaje' value='1'>
		<input type='hidden' name='MediosPago' value='4'>
		<input type='image' src='https://argentina.dineromail.com/imagenes/botones/pagar-tarjetas_bn.gif' border='0' name='submit' alt='Pagar con DineroMail'>
</form>
</div>