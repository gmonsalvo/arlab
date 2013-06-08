<?php

/**
 * This is the model class for table "formaPagoRecibos".
 *
 * The followings are the available columns in table 'formaPagoRecibos':
 * @property integer $id
 * @property integer $reciboId
 * @property string $fecha
 * @property integer $tipoFormaPago
 * @property string $numeroReferencia
 * @property string $monto
 */
class FormaPagoRecibos extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @return FormaPagoRecibos the static model class
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
		return 'formaPagoRecibos';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('reciboId, fecha, tipoFormaPago, monto', 'required'),
			array('reciboId, tipoFormaPago', 'numerical', 'integerOnly'=>true),
			array('numeroReferencia', 'length', 'max'=>50),
			array('monto', 'length', 'max'=>15),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, reciboId, fecha, tipoFormaPago, numeroReferencia, monto', 'safe', 'on'=>'search'),
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
		'DescripcionFormaPago' => array(self::BELONGS_TO, 'FormasPago', 'tipoFormaPago'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'reciboId' => 'Recibo',
			'fecha' => 'Fecha',
			'tipoFormaPago' => 'Tipo Forma Pago',
			'numeroReferencia' => 'Numero Referencia',
			'monto' => 'Monto',
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
		$criteria->compare('reciboId',$this->reciboId);
		$criteria->compare('fecha',$this->fecha,true);
		$criteria->compare('tipoFormaPago',$this->tipoFormaPago);
		$criteria->compare('numeroReferencia',$this->numeroReferencia,true);
		$criteria->compare('monto',$this->monto,true);

		return new CActiveDataProvider(get_class($this), array(
			'criteria'=>$criteria,
		));
	}
	public function behaviors()
	{
		return array('datetimeI18NBehavior2' => array('class' => 'ext.DateTimeI18NBehavior2'));
	}
}