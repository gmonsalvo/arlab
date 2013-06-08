<?php

$APIPassword = "AF6ACFC5-BE41-442B-95D1-7424303440AD";
$APIUserName = '6936948138E84A1C5BD585F18';
$Crypt = true;
$MerchantTransactionId = "1";
$UniqueMessageId = "1";
$StartDate = "2012-12-01";
$EndDate = "2012-12-08";
$OperationId = "";
$Hash = "";

$ns = 'https://api.dineromail.com/';
$wsdlPath="https://api.dineromail.com/DMAPI.asmx?WSDL";

try
{   
   $Hash = $MerchantTransactionId.$UniqueMessageId.$OperationId.$StartDate.$EndDate.$APIPassword;
   $Hash = MD5($Hash);
   MerchantTransactionId = encryptTripleDES($APIPassword,$MerchantTransactionId);
   $UniqueMessageId = encryptTripleDES($APIPassword,$UniqueMessageId);
   $OperationId = encryptTripleDES($APIPassword,$OperationId);
   $StartDate = encryptTripleDES($APIPassword,$StartDate);
   $EndDate = encryptTripleDES($APIPassword,$EndDate);
       
   $soap_options = array('trace' =>1,'exceptions'=>1);   
   $client = new SoapClient($wsdlPath,$soap_options);    
   
   $credential = new SOAPVar(array('APIUserName' => $APIUserName,
                           'APIPassword'=> $APIPassword)
                           , SOAP_ENC_OBJECT, 'APICredential', $ns);
                           
                     
   $request = array('Credential' =>$credential
               ,'Crypt' =>  $Crypt
               ,'MerchantTransactionId' => $MerchantTransactionId
               ,'UniqueMessageId' => $UniqueMessageId
               ,'OperationId' => $OperationId
               ,'StartDate' => $StartDate
               ,'EndDate' => $EndDate
               ,'Hash' => $Hash);   
   
   $result = $client->GetOperations($request);
   echo "<br/>";
   
   echo "Status: " . $result->GetOperationsResult->Status . "<br/>";
   echo "Message: " . $result->GetOperationsResult->Message . "<br/>";
   echo "MerchantTransactionId: " . $result->GetOperationsResult->MerchantTransactionId . "<br/>";
   echo "UniqueMessageId: " . $result->GetOperationsResult->UniqueMessageId . "<br/>";
   if($result->GetOperationsResult->Status=="OK")
   {
      foreach($result->GetOperationsResult->Operations as $Operation)
      {
         echo "<h2>Operation</h2><br/>";
         echo "Id: " . $Operation->Id . "<br/>";
         echo "Amount: " . $Operation->Amount . "<br/>";
         echo "Date: " . $Operation->Date . "<br/>";
         echo "NetAmount: " . $Operation->NetAmount . "<br/>";
         echo "PaymentMethod: " . $Operation->PaymentMethod . "<br/>";
         echo "Shares: " . $Operation->Shares . "<br/>";
         echo "State: " . $Operation->State . "<br/>";
         echo "<h3>Buyer</h3><br/>";
         echo "Address: " . $Operation->Buyer->Address . "<br/>";
         echo "Comments: " . $Operation->Buyer->Comments . "<br/>";
         echo "DocumentType: " . $Operation->Buyer->DocumentType . "<br/>";
         echo "DocumentNumber: " . $Operation->Buyer->DocumentNumber . "<br/>";
         echo "DocumentNumber: " . $Operation->Buyer->DocumentNumber . "<br/>";
         echo "LastName: " . $Operation->Buyer->LastName . "<br/>";         
         echo "Name: " . $Operation->Buyer->Name . "<br/>";         
         echo "Phone: " . $Operation->Buyer->Phone . "<br/>";   
         echo "Email: " . $Operation->Buyer->Email . "<br/>";
         echo "<h3>Seller</h3><br/>";
         echo "LastName: " . $Operation->Seller->LastName . "<br/>";         
         echo "Name: " . $Operation->Seller->Name . "<br/>";         
         echo "Phone: " . $Operation->Seller->Phone . "<br/>";   
         echo "Email: " . $Operation->Seller->Email . "<br/>";
         echo "DocumentType: " . $Operation->Seller->DocumentType . "<br/>";
         echo "DocumentNumber: " . $Operation->Seller->DocumentNumber . "<br/>";
      }
   
   }
}
catch (SoapFault $sf)
{
   echo "faultstring:". $sf->faultstring;
}
?>