<?php

/**
 * This is the model class for table "documentos".
 *
 * The followings are the available columns in table 'documentos':
 * @property string $tipoDocumento
 * @property integer $sucursal
 * @property integer $ultimoNumero
 */
class Documentos extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @return Documentos the static model class
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
		return 'documentos';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('tipoDocumento, sucursal, ultimoNumero', 'required'),
			array('sucursal, ultimoNumero', 'numerical', 'integerOnly'=>true),
			array('tipoDocumento', 'length', 'max'=>5),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('tipoDocumento, sucursal, ultimoNumero', 'safe', 'on'=>'search'),
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
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'tipoDocumento' => 'Tipo Documento',
			'sucursal' => 'Sucursal',
			'ultimoNumero' => 'Ultimo Numero',
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

		$criteria->compare('tipoDocumento',$this->tipoDocumento,true);
		$criteria->compare('sucursal',$this->sucursal);
		$criteria->compare('ultimoNumero',$this->ultimoNumero);

		return new CActiveDataProvider(get_class($this), array(
			'criteria'=>$criteria,
		));
	}
}