<?php
// este codigo sirve para mostrar el saldo en el grid, se usa la clase CGridColumn
Yii::import('zii.widgets.grid.CGridColumn');

class SaldoColumn extends CGridColumn {
	
    private $_acum; 
    private $_saldo;
    
    public function renderDataCellContent($row, $data)
    {
    	if ($data->tipoMov == 0)
    	{
    		$this->_saldo = $this->_acum + $data->monto;
    	}
    	else
    	{
    		$this->_saldo = $this->_acum - $data->monto;
    	}
    	$this->_acum = $this->_saldo;
 	echo Yii::app()->numberFormatter->format("#,##0.00",($this->_saldo));
    }
}

