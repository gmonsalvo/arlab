<?php
class RemoteController extends CController
{
    public function actions()
    {
       return array(
            'ws'=>array(
                'class'=>'CWebServiceAction',
                'serviceOptions'=>array('soapVersion'=>'1.2')
            ),
        );
    }
 
    /**
     * @param string the symbol of the stock
     * @return float the stock price
     * @soap
     */
    public function getPrice($id)
    {
        $cliente=Clientes::model()->findByPK($id);    
        return $cliente->getSaldo();
    }
}
?>