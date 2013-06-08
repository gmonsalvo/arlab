<?php
class CronMailCommand extends CConsoleCommand
{
	public function getHelp()
	{
		echo "Some cron job";
	}

	public function run($args)
	{
		//obtenemos la lista de clientes que estan activos osea saco suspendidos y baja
		$clientes=Clientes::model()->getActivos();
		
		foreach ($clientes as $cliente) {
		if (($cliente->getSaldo()>10) and ($cliente->notificacionesElectronicas==1)){
				
				$ban=1;
				$cuerpo="ESTIMADO CLIENTE:<br><br>Le recordamos que registra saldos pendientes, por favor sírvase cancelar los mismos a la brevedad para evitar los inconvenientes derivados de la suspensión del servicio.<br><br><br>";	
			
				$servicios=$cliente->getServiciosInternet();
				$cuerpo.="<b>Titular:</b>".$cliente->razonSocial."<br>";
				foreach ($servicios as $servicio) {
				$cuerpo.="<b>Servicio:</b> ".$servicio->domicilio.",".$servicio->ciudad->nombre."<br>"."<b>Cant. periodos vencidos:</b> ".$servicio->getPeriodosImpagos()."<br>";
                if ($servicio->getPeriodosImpagos()>=2){
                	$ban=0;
                }
				}	

				$cuerpo.="<br><br>Las formas de pago son:<li>	De lunes a viernes en nuestras oficinas de Mendoza 654 6º piso Ofic. 601 de 8 a 14 hs <li>	Transferencia y/o depósito bancario en cuyo caso debe solicitar nuestros datos bancarios <li>  Rapipago/pagfacil con un recargo de $8 + iva, si prefiere esta última opción solicítenos el cupón de pago que le servirá para todos los meses.<br><br> Si ud. efectúo pagos utilizando el sistema bancario, recuerde que los mismos no se imputan hasta tanto no sean INFORMADOS.<br><br> Aprovechamos para saludarlo atentamente.<br>";
		if ($ban==0){
			
		$headers="From: {ARLAB TI <noreply.arlab@gmail.com>}\n";
		$headers="Reply-To: karina@arlab.com.ar\n";
		$headers .= "MIME-Version: 1.0\n";
    	$headers .= "Content-type: text/html; charset=iso-8859-1\n";
		mail($cliente->mail,"Aviso de Vencimiento",$cuerpo,$headers);
		

		}	

		} //end if de saldo
		} //end for de clientes
		echo PHP_EOL;
	}
}