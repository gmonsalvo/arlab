<?php

/**
 * This is the model class for table "movimientosStock".
 *
 * The followings are the available columns in table 'movimientosStock':
 * @property string $id
 * @property integer $depositoId
 * @property integer $equipoId
 * @property integer $tipoMov
 * @property string $cantidad
 * @property string $observaciones
 * @property string $userStamp
 * @property string $timeStamp
 */
class MovimientosStock extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @return MovimientosStock the static model class
	 */
        public $subtotal;
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'movimientosStock';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('depositoId, equipoId, tipoMov, cantidad, userStamp, timeStamp,fecha', 'required'),
			array('depositoId, equipoId, tipoMov', 'numerical', 'integerOnly'=>true),
			array('cantidad', 'length', 'max'=>15),
			array('observaciones', 'length', 'max'=>200),
			array('userStamp', 'length', 'max'=>50),
                   
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, depositoId, equipoId, tipoMov, cantidad, observaciones, userStamp, timeStamp', 'safe', 'on'=>'search'),
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
                    'deposito' => array(self::BELONGS_TO, 'Depositos', 'depositoId'),
                    'equipo' => array(self::BELONGS_TO, 'Equipos', 'equipoId'),
		);
	}
        
        protected function beforeValidate()
	{
            $this->userStamp = Yii::app()->user->model->username;
            $this->timeStamp = Date("Y-m-d h:m:s");
            return parent::beforeValidate();
	}
	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
                        'fecha' => 'Fecha',
			'depositoId' => 'Deposito',
			'equipoId' => 'Equipo',
			'tipoMov' => 'Tipo Movimiento',
			'cantidad' => 'Cantidad',
			'observaciones' => 'Observaciones',
			'userStamp' => 'Creado Por',
			'timeStamp' => 'Fecha Creacion',
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

		$criteria->compare('id',$this->id,true);
		$criteria->compare('depositoId',$this->depositoId);
		$criteria->compare('equipoId',$this->equipoId);
		$criteria->compare('tipoMov',$this->tipoMov);
		$criteria->compare('cantidad',$this->cantidad,true);
		$criteria->compare('observaciones',$this->observaciones,true);
		$criteria->compare('userStamp',$this->userStamp,true);
		$criteria->compare('timeStamp',$this->timeStamp,true);
                $criteria->order="fecha desc";

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
        public function getIngresos($equipoId,$depositoId){
            $ingresoSQL = "SELECT SUM(cantidad) FROM movimientosStock WHERE equipoId='".$equipoId."' AND depositoId='".$depositoId."' AND tipoMov=0";
            //echo  $ingresoSQL;
            $ingresoQRY = Yii::app()->db->createCommand($ingresoSQL)->queryScalar();
            return $ingresoQRY;
        }     
            
        public function getEgresos($equipoId,$depositoId){
            $egresoSQL = "SELECT SUM(cantidad) FROM movimientosStock WHERE equipoId='".$equipoId."' AND depositoId='".$depositoId."' AND tipoMov=1";
            //echo $egresoSQL;
            $egresoQRY = Yii::app()->db->createCommand($egresoSQL)->queryScalar();
            return $egresoQRY;
        }     
        
             
        public function existencias(){
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;
		
		$criteria->compare('depositoId',$this->depositoId);
                $criteria->select="sum(cantidad) as Cantidad";
                $criteria->group="equipoId,tipoMov";
		
		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}