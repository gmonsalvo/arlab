<?php

/**
 * This is the model class for table "cambioPlan".
 *
 * The followings are the available columns in table 'cambioPlan':
 * @property integer $id
 * @property integer $servicioInternetId
 * @property string $fecha
 * @property integer $accion
 * @property string $observaciones
 * @property integer $planId
 * @property string $costoServicio
 * @property string $userStamp
 * @property string $timeStamp
 */
class CambioPlan extends CActiveRecord
{
	 const ACCION_UPGRADE=0;
     const ACCION_DOWNGRADE=1;
     const ACCION_BAJA=2;
     const ACCION_SUSPENSION=3;
     const ACCION_ACTIVACION=4;
     public $acciones=array('0'=>'UPGRADE','1'=>'DOWNGRADE','2'=>'BAJA','3'=>'ACTIVACION','4'=>'SUSPENSION');
     public $cliente="";
     
     /**
	 * Returns the static model of the specified AR class.
	 * @return CambioPlan the static model class
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
		return 'cambioPlan';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('servicioInternetId, fecha, accion, observaciones, planId, costoServicio,periodoInicio', 'required'),
			array('servicioInternetId, accion, planId', 'numerical', 'integerOnly'=>true),
                        array('periodoInicio', 'date', 'format'=>'yyyymm','message'=>'El formato del periodo es incorrecto'),
			array('observaciones', 'length', 'max'=>200),
			array('costoServicio', 'length', 'max'=>15),
			array('userStamp', 'length', 'max'=>50),
			array('timeStamp', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, servicioInternetId, fecha, accion, observaciones, planId, costoServicio, userStamp, timeStamp', 'safe', 'on'=>'search'),
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
                    'servicioInternet' => array(self::BELONGS_TO, 'ServiciosInternet', 'servicioInternetId'),
                    'plan' => array(self::BELONGS_TO, 'Planes', 'planId'),
                    
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'servicioInternetId' => 'Servicio Internet',
			'fecha' => 'Fecha',
			'accion' => 'Accion',
			'observaciones' => 'Observaciones',
                    	'estado' => 'Estado',
			'planId' => 'Plan',
                    	'periodoInicio' => 'Periodo Inicio',
			'costoServicio' => 'Costo Servicio',
			'userStamp' => 'User Stamp',
			'timeStamp' => 'Time Stamp',
		);
	}
        
        protected function beforeValidate()
	{
            $this->userStamp = Yii::app()->user->model->username;
            $this->timeStamp = Date("Y-m-d h:m:s");
            return parent::beforeValidate();
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
		$criteria->compare('servicioInternetId',$this->servicioInternetId);
		$criteria->compare('fecha',$this->fecha,true);
		$criteria->compare('accion',$this->accion);
		$criteria->compare('observaciones',$this->observaciones,true);
		$criteria->compare('planId',$this->planId);
		$criteria->compare('costoServicio',$this->costoServicio,true);
		$criteria->compare('userStamp',$this->userStamp,true);
		$criteria->compare('timeStamp',$this->timeStamp,true);
                $criteria->order="fecha desc";

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	public function getDescripcionAccion($accion)
	{

	 return $this->acciones[$accion];	
	}
	public function getAcciones()
	{

		return $this->acciones;
	}
}