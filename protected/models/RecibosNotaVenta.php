<?php

/**
 * This is the model class for table "recibosNotaVenta".
 *
 * The followings are the available columns in table 'recibosNotaVenta':
 * @property integer $id
 * @property integer $reciboId
 * @property integer $notaVentaId
 * @property string $monto
 */
class RecibosNotaVenta extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @return RecibosNotaVenta the static model class
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
		return 'recibosNotaVenta';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('reciboId, notaVentaId, monto', 'required'),
			array('reciboId, notaVentaId', 'numerical', 'integerOnly'=>true),
			array('monto', 'length', 'max'=>15),
			array('monto', 'montoNotaVenta'),
            array('reciboId+notaVentaId', 'application.extensions.uniqueMultiColumnValidator','message'=>'Ya esta cargado este saldo en el recibo actual.'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, reciboId, notaVentaId, monto', 'safe', 'on'=>'search'),
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
		'Recibos' => array(self::BELONGS_TO, 'Recibos', 'reciboId'),
		'NotaVenta'=>array(self::BELONGS_TO, 'NotaVenta','notaVentaId'),
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
			'notaVentaId' => 'Nota Venta',
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
		$criteria->compare('notaVentaId',$this->notaVentaId);
		$criteria->compare('monto',$this->monto,true);

		return new CActiveDataProvider(get_class($this), array(
			'criteria'=>$criteria,
		));
	}

	public function montoNotaVenta($attribute,$params)
	{
	    $notaVenta = NotaVenta::model()->findByPK($this->notaVentaId); 
	 
	    if($this->monto>$notaVenta->getSaldoNoFormat())
	      $this->addError($attribute, 'El monto a pagar no puede superar el saldo de la nota de venta seleccionada');
	}
}