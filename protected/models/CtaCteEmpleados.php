<?php

/**
 * This is the model class for table "ctaCteEmpleados".
 *
 * The followings are the available columns in table 'ctaCteEmpleados':
 * @property integer $id
 * @property string $fecha
 * @property integer $tipoMov
 * @property integer $empleadoId
 * @property integer $conceptoId
 * @property integer $periodo
 * @property string $monto
 * @property string $descripcion
 * @property string $userStamp
 * @property string $timeStamp
 *
 * The followings are the available model relations:
 * @property ConceptosEmpleados $concepto
 * @property Empleados $empleado
 */
class CtaCteEmpleados extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @return CtaCteEmpleados the static model class
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
		return 'ctaCteEmpleados';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('fecha, tipoMov, empleadoId, conceptoId, periodo, monto, userStamp, timeStamp', 'required'),
			array('tipoMov, empleadoId, conceptoId, periodo', 'numerical', 'integerOnly'=>true),
			array('periodo', 'length', 'max'=>6),
			array('monto', 'length', 'max'=>15),
			array('descripcion', 'length', 'max'=>100),
			array('userStamp', 'length', 'max'=>50),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, fecha, tipoMov, empleadoId, conceptoId, periodo, monto, descripcion, userStamp, timeStamp', 'safe', 'on'=>'search'),
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
			'concepto' => array(self::BELONGS_TO, 'ConceptosEmpleados', 'conceptoId'),
			'empleado' => array(self::BELONGS_TO, 'Empleados', 'empleadoId'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'fecha' => 'Fecha',
			'tipoMov' => 'Tipo Mov',
			'empleadoId' => 'Empleado',
			'conceptoId' => 'Concepto',
			'periodo' => 'Periodo',
			'monto' => 'Monto',
			'descripcion' => 'Descripcion',
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
		$criteria->compare('fecha',$this->fecha,true);
		$criteria->compare('tipoMov',$this->tipoMov);
		$criteria->compare('empleadoId',$this->empleadoId);
		$criteria->compare('conceptoId',$this->conceptoId);
		$criteria->compare('periodo',$this->periodo);
		$criteria->compare('monto',$this->monto,true);
		$criteria->compare('descripcion',$this->descripcion,true);
		$criteria->compare('userStamp',$this->userStamp,true);
		$criteria->compare('timeStamp',$this->timeStamp,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	protected function beforeValidate()
	{
            $this->userStamp = Yii::app()->user->model->username;
            $this->timeStamp = Date("Y-m-d h:m:s");
            return parent::beforeValidate();
	}
	
}