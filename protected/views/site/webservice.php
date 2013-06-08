<?php
ini_set ('soap.wsdl_cache_enable',0); 
ini_set ('soap.wsdl_cache_ttl',0);

$client=new SoapClient('http://127.0.0.1:8080/arlab/index.php/remote/ws');
echo $client->getPrice('1');

?>