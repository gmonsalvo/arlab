<?php

/**
 * This is the model class for table "pesificaciones".
 *
 * The followings are the available columns in table 'pesificaciones':
 * @property integer $id
 * @property string $fecha
 * @property integer $pesificadorId
 * @property string $montoAcreditar
 * @property string $montoGastos
 * @property integer $sucursalId
 * @property string $userStamp
 * @property string $timeStamp
 * @property integer $estado
 * The followings are the available model relations:
 * @property DetallePesificaciones[] $detallePesificaciones
 * @property Pesificadores $pesificador
 * @property Sucursales $sucursal
 */
class Pesificaciones extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @return Pesificaciones the static model class
	 */
        const ESTADO_ABIERTO=0;
	const ESTADO_CERRADO=1;
         
         private $montototal;
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'pesificaciones';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('pesificadorId, sucursalId, estado', 'numerical', 'integerOnly'=>true),
			array('userStamp', 'length', 'max'=>45),
                        array('montoAcreditar, montoGastos', 'length', 'max'=>15),
			array('fecha, timeStamp', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, fecha, pesificadorId, sucursalId, userStamp, timeStamp, estado', 'safe', 'on'=>'search'),
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
			'detallePesificaciones' => array(self::HAS_MANY, 'DetallePesificaciones', 'pesificacionId'),
			'pesificador' => array(self::BELONGS_TO, 'Pesificadores', 'pesificadorId'),
			'sucursal' => array(self::BELONGS_TO, 'Sucursales', 'sucursalId'),
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
			'pesificadorId' => 'Pesificador',
                        'montoAcreditar' => 'Monto a Acreditar',
                        'montoGastos' => 'Gastos',
			'sucursalId' => 'Sucursal',
			'userStamp' => 'User Stamp',
			'timeStamp' => 'Time Stamp',
                        'estado' => 'Estado',
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
		$criteria->compare('pesificadorId',$this->pesificadorId);
                $criteria->compare('montoAcreditar',$this->montoAcreditar);
                $criteria->compare('montoGastos',$this->montoGastos);
		$criteria->compare('sucursalId',$this->sucursalId);
                $criteria->compare('estado',$this->estado);
		$criteria->compare('userStamp',$this->userStamp,true);
		$criteria->compare('timeStamp',$this->timeStamp,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
	
	public function searchById()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;
		$criteria->condition= "pesificacionId=:id";
		$criteria->params = array(':id'=>$this->id);
		return new CActiveDataProvider(new DetallePesificaciones, array(
			'criteria'=>$criteria,
		));
	}
        
        	
	public function searchPesificacionesSinCompletar()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;
                $criteria->condition= "estado=:estado";
		$criteria->params = array(':estado'=>  Pesificaciones::ESTADO_ABIERTO);

		//$criteria->condition= "(t.montoAcreditar+t.montoGastos) NOT IN (SELECT SUM(cheques.montoOrigen) FROM cheques, detallePesificaciones WHERE detallePesificaciones.chequeId=cheques.id AND detallePesificaciones.pesificacionId=t.id)";
		return new CActiveDataProvider(new Pesificaciones, array(
			'criteria'=>$criteria,
		));
	}
	
        public function getMontototal()
        {
            $sql="SELECT SUM(cheques.montoOrigen) FROM cheques, detallePesificaciones, pesificaciones WHERE detallePesificaciones.chequeId=cheques.id AND detallePesificaciones.pesificacionId=pesificaciones.id AND pesificaciones.id='".$this->id."'";
            $this->montototal=Yii::app()->db->createCommand($sql)->queryScalar();
            return Yii::app()->db->createCommand($sql)->queryScalar();
        }
	
	
	protected function beforeValidate()
    {
        $this->userStamp = Yii::app()->user->model->username;
        $this->timeStamp = Date("Y-m-d h:m:s");
	$this->sucursalId = Yii::app()->user->model->sucursalId;

        return parent::beforeValidate();
    }
    
    	public function getTypeOptions()
	{
		return array(
			self::ESTADO_ABIERTO=>'Abierto',
			self::ESTADO_CERRADO=>'Cerrado',
		);
	}
	
	public function getTypeDescription()
	{
		$options = array();
		$options = $this->getTypeOptions();
		return $options[$this->estado];
		
	}
}