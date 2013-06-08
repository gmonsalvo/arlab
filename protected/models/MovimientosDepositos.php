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

class MovimientosDepositos extends CFormModel
{
  public $fecha;
  public $depositoOrigen;
  public $depositoDestino;
  public $equipoId;
  public $cantidad;
  public $observaciones;

  public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('depositoOrigen,depositoDestino, equipoId,cantidad,fecha', 'required'),
			array('depositoOrigen,depositoDestino, equipoId', 'numerical', 'integerOnly'=>true),
			array('cantidad', 'length', 'max'=>15),
			array('observaciones', 'length', 'max'=>200),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, depositoOrigen,depositoDestino, equipoId, cantidad, observaciones', 'safe', 'on'=>'search'),
		);
	}
  public function attributeLabels()
	{
		return array(
			'fecha' => 'Fecha',
			'depositoOrigen' => 'Deposito Origen',
                    	'depositoDestino' => 'Deposito Destino',
			'equipoId' => 'Equipamiento',
			'cantidad' => 'Cantidad',
			'observaciones' => 'Observaciones',
			
		);
	}
  
}
?>
