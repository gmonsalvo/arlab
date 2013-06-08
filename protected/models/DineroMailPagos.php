<?php

/**
 * This is the model class for table "dineroMailPagos".
 *
 * The followings are the available columns in table 'dineroMailPagos':
 * @property integer $id
 * @property string $fechaPago
 * @property string $monto
 * @property string $montoNeto
 * @property string $numeroTransaccion
 * @property integer $clienteId
 * @property string $nroPagoElectronico
 * @property integer $estado
 *
 * The followings are the available model relations:
 * @property Clientes $cliente
 */
class DineroMailPagos extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @return DineroMailPagos the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'dineroMailPagos';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('fechaPago, monto, montoNeto, numeroTransaccion, clienteId, nroPagoElectronico', 'required'),
			array('clienteId, estado', 'numerical', 'integerOnly'=>true),
			array('monto, montoNeto', 'length', 'max'=>15),
			array('numeroTransaccion, nroPagoElectronico', 'length', 'max'=>10),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, fechaPago, monto, montoNeto, numeroTransaccion, clienteId, nroPagoElectronico, estado', 'safe', 'on'=>'search'),
		);
	}

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
			'cliente' => array(self::BELONGS_TO, 'Clientes', 'clienteId'),
		);
	}


	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'fechaPago' => 'Fecha Pago',
			'monto' => 'Monto',
			'montoNeto' => 'Monto Neto',
			'numeroTransaccion' => 'Numero Transaccion',
			'clienteId' => 'Cliente',
			'nroPagoElectronico' => 'Nro Pago Electronico',
			'estado' => 'Estado',
		);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
	 */
	public function search()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('id',$this->id);
		$criteria->compare('fechaPago',$this->fechaPago,true);
		$criteria->compare('monto',$this->monto,true);
		$criteria->compare('montoNeto',$this->montoNeto,true);
		$criteria->compare('numeroTransaccion',$this->numeroTransaccion,true);
		$criteria->compare('clienteId',$this->clienteId);
		$criteria->compare('nroPagoElectronico',$this->nroPagoElectronico,true);
		$criteria->compare('estado',$this->estado);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}