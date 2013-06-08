<?php

/**
 * This is the model class for table "conceptosFlujoFondos".
 *
 * The followings are the available columns in table 'conceptosFlujoFondos':
 * @property integer $id
 * @property string $nombre
 * @property integer $tipoConcepto
 *
 * The followings are the available model relations:
 * @property FlujoFondos[] $flujoFondoses
 */
class ConceptosFlujoFondos extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @return ConceptosFlujoFondos the static model class
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
		return 'conceptosFlujoFondos';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('tipoConcepto', 'required'),
			array('tipoConcepto', 'numerical', 'integerOnly'=>true),
			array('nombre', 'length', 'max'=>40),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, nombre, tipoConcepto', 'safe', 'on'=>'search'),
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
			'flujoFondoses' => array(self::HAS_MANY, 'FlujoFondos', 'conceptoId'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'nombre' => 'Nombre',
			'tipoConcepto' => 'Tipo Concepto',
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
		$criteria->compare('nombre',$this->nombre,true);
		$criteria->compare('tipoConcepto',$this->tipoConcepto);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}