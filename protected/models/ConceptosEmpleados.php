<?php

/**
 * This is the model class for table "conceptosEmpleados".
 *
 * The followings are the available columns in table 'conceptosEmpleados':
 * @property integer $id
 * @property string $nombre
 * @property string $userStamp
 * @property string $timeStamp
 *
 * The followings are the available model relations:
 * @property CtaCteEmpleados[] $ctaCteEmpleadoses
 */
class ConceptosEmpleados extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @return ConceptosEmpleados the static model class
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
		return 'conceptosEmpleados';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('nombre, userStamp, timeStamp', 'required'),
			array('nombre', 'length', 'max'=>100),
			array('userStamp', 'length', 'max'=>50),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, nombre, userStamp, timeStamp', 'safe', 'on'=>'search'),
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
			'ctaCteEmpleadoses' => array(self::HAS_MANY, 'CtaCteEmpleados', 'conceptoId'),
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

		$criteria->compare('id',$this->id);
		$criteria->compare('nombre',$this->nombre,true);
		$criteria->compare('userStamp',$this->userStamp,true);
		$criteria->compare('timeStamp',$this->timeStamp,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}