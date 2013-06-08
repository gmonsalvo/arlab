<?php

/**
 * This is the model class for table "gestionesSoportes".
 *
 * The followings are the available columns in table 'gestionesSoportes':
 * @property integer $id
 * @property integer $soporteId
 * @property string $fecha
 * @property string $detalle
 * @property string $usuario
 *
 * The followings are the available model relations:
 * @property Soportes $soporte
 */
class GestionesSoportes extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @return GestionesSoportes the static model class
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
		return 'gestionesSoportes';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('soporteId, detalle, usuario', 'required'),
			array('soporteId', 'numerical', 'integerOnly'=>true),
			array('detalle', 'length', 'max'=>255),
			array('usuario', 'length', 'max'=>50),
			array('fecha', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, soporteId, fecha, detalle, usuario', 'safe', 'on'=>'search'),
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
			'soporte' => array(self::BELONGS_TO, 'Soportes', 'soporteId'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'soporteId' => 'Soporte',
			'fecha' => 'Fecha',
			'detalle' => 'Detalle',
			'usuario' => 'Usuario',
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
		$criteria->compare('soporteId',$this->soporteId);
		$criteria->compare('fecha',$this->fecha,true);
		$criteria->compare('detalle',$this->detalle,true);
		$criteria->compare('usuario',$this->usuario,true);

		return new CActiveDataProvider(get_class($this), array(
			'criteria'=>$criteria,
		));
	}
}