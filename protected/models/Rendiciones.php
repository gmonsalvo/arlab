<?php

/**
 * This is the model class for table "rendiciones".
 *
 * The followings are the available columns in table 'rendiciones':
 * @property integer $id
 * @property string $fecha
 * @property integer $periodoInicio
 * @property integer $periodoFin
 * @property integer $cobradorId
 * @property integer $estado
 * @property string $userStamp
 * @property string $timeStamp
 *
 * The followings are the available model relations:
 * @property Cobradores $cobrador
 * @property RendicionesRecibos $id0
 */
class Rendiciones extends CActiveRecord
{

	private $totalPagado;

	const ESTADO_CERRADO = 1;
	const ESTADO_ABIERTO = 0;

	/**
	 * Returns the static model of the specified AR class.
	 * @return Rendiciones the static model class
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
		return 'rendiciones';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('fecha, periodoInicio, periodoFin, cobradorId, estado, userStamp, timeStamp', 'required'),
			array('periodoInicio, periodoFin, cobradorId, estado', 'numerical', 'integerOnly'=>true),
			array('userStamp', 'length', 'max'=>50),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, fecha, periodoInicio, periodoFin, cobradorId, estado, userStamp, timeStamp', 'safe', 'on'=>'search'),
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
			'cobrador' =>array(self::BELONGS_TO, 'Cobradores', 'cobradorId'),
			'recibos' => array(self::MANY_MANY, 'Recibos', 'rendicionesRecibos(rendicionId, reciboId)'),
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
			'periodoInicio' => 'Periodo Inicio',
			'periodoFin' => 'Periodo Fin',
			'cobradorId' => 'Cobrador',
			'estado' => 'Estado',
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
		$criteria->compare('periodoInicio',$this->periodoInicio);
		$criteria->compare('periodoFin',$this->periodoFin);
		$criteria->compare('cobradorId',$this->cobradorId);
		$criteria->compare('estado',$this->estado);
		$criteria->compare('userStamp',$this->userStamp,true);
		$criteria->compare('timeStamp',$this->timeStamp,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	public function getTotalPagado(){
		if(!isset($this->totalPagado)){
			$this->totalPagado = 0;
			foreach($this->recibos as $recibo){
				$this->totalPagado+=$recibo->totalFormaPago;
			}
		}
		return $this->totalPagado;
	}
}