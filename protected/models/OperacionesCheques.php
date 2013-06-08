<?php

/**
 * This is the model class for table "operacionesCheques".
 *
 * The followings are the available columns in table 'operacionesCheques':
 * @property integer $id
 * @property integer $operadorId
 * @property integer $clienteId
 * @property string $montoNetoTotal
 * @property string $fecha
 * @property string $userStamp
 * @property string $timeStamp
 * @property integer $sucursalId
 *
 * The followings are the available model relations:
 * @property Cheques[] $cheques
 * @property Clientes $cliente
 * @property Sucursales $sucursal
 * @property Operadores $operador
 */
class OperacionesCheques extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @return OperacionesCheques the static model class
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
		return 'operacionesCheques';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('operadorId, clienteId, montoNetoTotal, fecha, userStamp, timeStamp, sucursalId', 'required'),
			array('operadorId, clienteId, sucursalId', 'numerical', 'integerOnly'=>true),
			array('montoNetoTotal', 'length', 'max'=>15),
			array('userStamp', 'length', 'max'=>45),
			array('timeStamp', 'default', 'value'=>new CDbExpression('NOW()'),'setOnEmpty'=>false,'on'=>'insert'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, operadorId, clienteId, montoNetoTotal, fecha, userStamp, timeStamp, sucursalId', 'safe', 'on'=>'search'),
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
			'cheques' => array(self::HAS_MANY, 'Cheques', 'operacionChequeId'),
			'cliente' => array(self::BELONGS_TO, 'Clientes', 'clienteId'),
			'sucursal' => array(self::BELONGS_TO, 'Sucursales', 'sucursalId'),
			'operador' => array(self::BELONGS_TO, 'Operadores', 'operadorId'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'operadorId' => 'Operador',
			'clienteId' => 'Cliente',
			'montoNetoTotal' => 'Monto Neto Total',
			'fecha' => 'Fecha',
			'userStamp' => 'User Stamp',
			'timeStamp' => 'Time Stamp',
			'sucursalId' => 'Sucursal',
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
		$criteria->compare('operadorId',$this->operadorId);
		$criteria->compare('clienteId',$this->clienteId);
		$criteria->compare('montoNetoTotal',$this->montoNetoTotal,true);
		$criteria->compare('fecha',$this->fecha,true);
		$criteria->compare('userStamp',$this->userStamp,true);
		$criteria->compare('timeStamp',$this->timeStamp,true);
		$criteria->compare('sucursalId',$this->sucursalId);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
	
	protected function beforeValidate()
    {
        $this->userStamp = Yii::app()->user->model->username;
        $this->timeStamp = Date("Y-m-d h:m:s");
		$this->sucursalId = Yii::app()->user->model->sucursalId;

        return parent::beforeValidate();
    }
	
	public function behaviors()
	{
		return array('datetimeI18NBehavior' => array('class' => 'ext.DateTimeI18NBehavior')); // 'ext' is in Yii 1.0.8 version. For early versions, use 'application.extensions' instead.
	}
	
	public function getMontoNetoTotal()
	{
		/*$criteria=new CDbCriteria;	
		$criteria->condition=" DATE(t.timeStamp)='".Date('Y-m-d')."'";
		$criteria->order=' t.timeStamp DESC';
		$criteria->from='tmpCheques';*/
		$command = Yii::app()->db->createCommand();
		$tmpCheques = $command->select('*')->from('tmpCheques')->where('DATE(timeStamp)=:fechahoy AND userStamp=:username',array(':fechahoy'=>Date('Y-m-d'),':username'=>Yii::app()->user->model->username))->queryAll();
		$montoNetoTotal=0;
		foreach ($tmpCheques as $tmpCheque)
		{
			$montoNetoTotal+=$tmpCheque['montoNeto'];
		}
		return $montoNetoTotal;
	}
}