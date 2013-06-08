<?php

/**
 * This is the model class for table "facturas".
 *
 * The followings are the available columns in table 'facturas':
 * @property string $id
 * @property integer $numero
 * @property integer $puntoVenta
 * @property string $tipoFactura
 * @property string $fecha
 * @property string $clienteId
 * @property string $recargo
 * @property string $descuento
 * @property string $montoTotal
 * @property string $userStamp
 * @property string $timeStamp
 */
class Facturas extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @return Facturas the static model class
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
		return 'facturas';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('numero, puntoVenta, tipoFactura, fecha, clienteId, userStamp, timeStamp', 'required'),
			array('numero, puntoVenta', 'numerical', 'integerOnly'=>true),
			array('tipoFactura', 'length', 'max'=>5),
			array('clienteId', 'length', 'max'=>20),
			array('recargo, descuento, montoTotal', 'length', 'max'=>15),
			array('userStamp', 'length', 'max'=>50),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, numero, puntoVenta, tipoFactura, fecha, clienteId, recargo, descuento, montoTotal, userStamp, timeStamp', 'safe', 'on'=>'search'),
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
                    'notasVenta'=>array(self::MANY_MANY, 'NotaVenta','facturasNotaVenta(facturaId, notaVentaId)'),
                    'cliente' => array(self::BELONGS_TO, 'Clientes', 'clienteId'),
                 	'facturasNotaVenta' => array(self::HAS_MANY, 'FacturasNotaVenta', 'facturaId'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'numero' => 'Numero',
			'puntoVenta' => 'Punto Venta',
			'tipoFactura' => 'Tipo Factura',
			'fecha' => 'Fecha',
			'clienteId' => 'Cliente',
			'recargo' => 'Recargo',
			'descuento' => 'Descuento',
			'montoTotal' => 'Monto Total',
			'userStamp' => 'User Stamp',
			'timeStamp' => 'Time Stamp',
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

		$criteria->compare('id',$this->id,true);
		$criteria->compare('numero',$this->numero);
		$criteria->compare('puntoVenta',$this->puntoVenta);
		$criteria->compare('tipoFactura',$this->tipoFactura,true);
		$criteria->compare('fecha',$this->fecha,true);
		$criteria->compare('clienteId',$this->clienteId,true);
		$criteria->compare('recargo',$this->recargo,true);
		$criteria->compare('descuento',$this->descuento,true);
		$criteria->compare('montoTotal',$this->montoTotal,true);
		$criteria->compare('userStamp',$this->userStamp,true);
		$criteria->compare('timeStamp',$this->timeStamp,true);
        $criteria->order="id desc";

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
        
     protected function beforeValidate() {
        $this->userStamp = Yii::app()->user->model->username;
        $this->timeStamp = Date("Y-m-d h:m:s");
        return parent::beforeValidate();
    }
    
        public function behaviors()
	{
		return array('datetimeI18NBehavior2' => array('class' => 'ext.DateTimeI18NBehavior2'));
	}
}