<?php

/**
 * This is the model class for table "empleados".
 *
 * The followings are the available columns in table 'empleados':
 * @property integer $id
 * @property string $nombreApellido
 * @property string $fechaAlta
 * @property string $sueldoActual
 * @property string $montoPrestamo
 * @property string $userStamp
 * @property string $timeStamp
 *
 * The followings are the available model relations:
 * @property CtaCteEmpleados[] $ctaCteEmpleadoses
 */
class Empleados extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @return Empleados the static model class
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
		return 'empleados';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('nombreApellido, sueldoActual, userStamp, timeStamp', 'required'),
			array('nombreApellido', 'length', 'max'=>100),
			array('sueldoActual, montoPrestamo', 'length', 'max'=>15),
			array('userStamp', 'length', 'max'=>50),
			array('fechaAlta', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, nombreApellido, fechaAlta, sueldoActual, montoPrestamo, userStamp, timeStamp', 'safe', 'on'=>'search'),
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
			'ctaCteEmpleadoses' => array(self::HAS_MANY, 'CtaCteEmpleados', 'empleadoId'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'nombreApellido' => 'Nombre Apellido',
			'fechaAlta' => 'Fecha Alta',
			'sueldoActual' => 'Sueldo Actual',
			'montoPrestamo' => 'Monto Prestamo',
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
		$criteria->compare('nombreApellido',$this->nombreApellido,true);
		$criteria->compare('fechaAlta',$this->fechaAlta,true);
		$criteria->compare('sueldoActual',$this->sueldoActual,true);
		$criteria->compare('montoPrestamo',$this->montoPrestamo,true);
		$criteria->compare('userStamp',$this->userStamp,true);
		$criteria->compare('timeStamp',$this->timeStamp,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}