<?php
$reporte = simplexml_load_file('https://argentina.dineromail.com/vender/ConsultaPago.asp?Email=gabriel@arlab.com.ar&Acount=00343173&Pin=ROGUOHRYMM&StartDate=20130301&EndDate=20130331&XML=1');
 
echo $reporte->Email;
echo "<pre><br>";
echo "Cant. de Registros:".count($reporte->Collections->Collection)."<br>";
foreach($reporte->Collections->Collection as $c){

echo "Cod. Pago Electronico:".$c->attributes()->Trx_id."<br>";
echo "Fecha Pago:".$c->Trx_Date."</br>";
echo "Monto Abonado:".$c->Trx_Payment."</br>";
echo "Monto Neto:".$c->Trx_montoNeto."</br>";
echo "Numero de Transaccion:".$c->Trx_Number."</br>";
echo "Lugar de Pago:".$c->Trx_PaymentMean."</br></br>";
   

}
echo "</pre><br>";

?>