<?php

/**
 * This is the model class for table "ctaCteClientes".
 *
 * The followings are the available columns in table 'ctaCteClientes':
 * @property string $id
 * @property integer $tipoMov
 * @property integer $notaVentaId
 * @property string $fecha
 * @property integer $conceptoId
 * @property string $monto
 * @property string $userStamp
 * @property string $timeStamp
 */
class CtaCteClientes extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @return CtaCteClientes the static model class
	 */
	 // Tipos de movimientos
    const TYPE_CREDITO=1;
    const TYPE_DEBITO=0;
    private $acum;
    private $saldo;
	
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'ctaCteClientes';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('tipoMov, notaVentaId, fecha, conceptoId, monto, timeStamp', 'required'),
			array('tipoMov, notaVentaId, conceptoId', 'numerical', 'integerOnly'=>true),
			array('monto', 'length', 'max'=>15),
			array('userStamp', 'length', 'max'=>50),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, tipoMov, notaVentaId, fecha, conceptoId, monto, userStamp, timeStamp', 'safe', 'on'=>'search'),
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
		'notaVenta' => array(self::BELONGS_TO, 'NotaVenta', 'notaVentaId'),
		'concepto' => array(self::BELONGS_TO, 'Conceptos', 'conceptoId'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'tipoMov' => 'Tipo Mov',
			'notaVentaId' => 'Nota Venta',
			'fecha' => 'Fecha',
			'conceptoId' => 'Concepto',
			'monto' => 'Monto',
			'userStamp' => 'User Stamp',
			'timeStamp' => 'Time Stamp',
		);
	}
	
	public function getTypeOptions()
	{
		return array(
			self::TYPE_CREDITO=>'Credito',
			self::TYPE_DEBITO=>'Debito',
		);
	}
	
	public function getTypeDescription()
	{
		$options = array();
		$options = $this->getTypeOptions();
		return $options[$this->tipoMov];
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
		$criteria->compare('tipoMov',$this->tipoMov);
		$criteria->compare('notaVentaId',$this->notaVentaId);
		$criteria->compare('fecha',$this->fecha,true);
		$criteria->compare('conceptoId',$this->conceptoId);
		$criteria->compare('monto',$this->monto,true);
		$criteria->compare('userStamp',$this->userStamp,true);
		$criteria->compare('timeStamp',$this->timeStamp,true);

		return new CActiveDataProvider(get_class($this), array(
			'criteria'=>$criteria,
		));
	}
}