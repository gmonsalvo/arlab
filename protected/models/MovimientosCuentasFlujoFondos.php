<?php

/**
 * This is the model class for table "movimientosDepositos".
 *
 * The followings are the available columns in table 'movimientosStock':
 * @property string $id
 * @property integer $depositoId
 * @property integer $equipoId
 * @property integer $tipoMov
 * @property string $cantidad
 * @property string $observaciones
 * @property string $userStamp
 * @property string $timeStamp
 */

class MovimientosCuentasFlujoFondos extends CFormModel
{
  public $fecha;
  public $cuentaOrigen;
  public $cuentaDestino;
  public $tipoFondoId;
  public $conceptoId;
  public $monto;
  public $descripcion;

  public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('cuentaOrigen,cuentaDestino, tipoFondoId,monto,fecha,descripcion', 'required'),
			array('cuentaOrigen,cuentaDestino, tipoFondoId,conceptoId', 'numerical', 'integerOnly'=>true),
			array('monto', 'saldoTipoFondo'),
			array('monto', 'length', 'max'=>15),
			array('descripcion', 'length', 'max'=>200),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, depositoOrigen,depositoDestino, equipoId, cantidad, observaciones', 'safe', 'on'=>'search'),
		);
	}
  public function attributeLabels()
	{
		return array(
			'fecha' => 'Fecha',
			'cuentaOrigen' => 'Cuenta Origen',
            'cuentaDestino' => 'Deposito Destino',
			'tipoFondoId' => 'Tipo Fondo',
			'conceptoId' => 'Concepto',
			'monto' => 'Monto',
			'descripcion' => 'Descripcion',
		);
	}

	public function saldoTipoFondo($attribute,$params)
	{
	    $saldo = FlujoFondos::model()->getSaldoPorTipoFondo($this->tipoFondoId,$this->cuentaOrigen); 
	 
	    if($this->monto>$saldo)
	      $this->addError($attribute, 'El monto especificado excede el saldo disponible en la caja para este tipo de fondo, Saldo Actual:$'.$saldo);
	}
  
}
?>
