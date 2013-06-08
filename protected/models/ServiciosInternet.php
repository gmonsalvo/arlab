<?php

/**
 * This is the model class for table "servicios_internet".
 *
 * The followings are the available columns in table 'servicios_internet':
 * @property string $id
 * @property string $domicilio
 * @property integer $ciudadId
 * @property string $telefono
 * @property string $fecha_instalacion
 * @property integer $servidorId
 * @property integer $repetidorId
 * @property integer $nivel_senal
 * @property string $ip_lan
 * @property string $ip_antena
 * @property integer $equipoId
 * @property integer $cicloId
 * @property integer $clienteId
 * @property string $costoServicio
 * @property integer $planId
 * @property integer $barrioId
 *
 * The followings are the available model relations:
 * @property Ciudades $ciudad
 * @property Nodos $servidor
 * @property Nodos $repetidor
 * @property Equipos $equipo
 * @property Ciclos $ciclo
 * @property Clientes $cliente
 * @property Barrios $barrio
 */
class ServiciosInternet extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @return ServiciosInternet the static model class
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
		return 'servicios_internet';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('servidorId, repetidorId, equipoId, cicloId, costoServicio,ip_lan,ip_antena,planId,fecha_instalacion,instaladoresId,tipoConfiguracionAntena', 'required'),
			array('ciudadId, servidorId, repetidorId, nivel_senal, equipoId, cicloId, clienteId, planId, barrioId', 'numerical', 'integerOnly'=>true),
			array('domicilio, telefono', 'length', 'max'=>100),
			array('ip_lan,ip_antena', 'ext.validators.FIpValidator','version'=>'ipv4','enableClientValidation'=>true),
			array('ip_antena+servidorId', 'application.extensions.uniqueMultiColumnValidator'),
			array('ip_lan, ip_antena, costoServicio', 'length', 'max'=>15),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, domicilio, ciudadId, telefono, fecha_instalacion, servidorId, repetidorId, nivel_senal, ip_lan, ip_antena, equipoId, cicloId, clienteId, costoServicio, planId, barrioId', 'safe', 'on'=>'search'),
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
			'ciudad' => array(self::BELONGS_TO, 'Ciudades', 'ciudadId'),
			'servidor' => array(self::BELONGS_TO, 'Nodos', 'servidorId'),
			'repetidor' => array(self::BELONGS_TO, 'Nodos', 'repetidorId'),
			'equipo' => array(self::BELONGS_TO, 'Equipos', 'equipoId'),
			'plan' => array(self::BELONGS_TO, 'Planes', 'planId'),
			'ciclo' => array(self::BELONGS_TO, 'Ciclos', 'cicloId'),
			'cliente' => array(self::BELONGS_TO, 'Clientes', 'clienteId'),
			'barrio' => array(self::BELONGS_TO, 'Barrios', 'barrioId'),
            'instaladores' => array(self::BELONGS_TO, 'Instaladores', 'instaladoresId'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'domicilio' => 'Domicilio',
			'ciudadId' => 'Ciudad',
			'telefono' => 'Telefono',
			'fecha_instalacion' => 'Fecha Instalacion',
                    	'instaladoresId' => 'Instaladores',
			'servidorId' => 'Servidor / Gateway',
			'repetidorId' => 'Repetidor (nodo al que se conecta)',
			'nivel_senal' => 'Nivel Senal',
			'ip_lan' => 'IP PC/LAN',
			'ip_antena' => 'IP Antena',
			'equipoId' => 'Equipo',
			'cicloId' => 'Ciclo',
			'clienteId' => 'Cliente',
			'costoServicio' => 'Costo Servicio',
			'planId' => 'Plan',
			'barrioId' => 'Barrio',
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

		$criteria->compare('id',$this->id,true);
		$criteria->compare('domicilio',$this->domicilio,true);
		$criteria->compare('ciudadId',$this->ciudadId);
		$criteria->compare('telefono',$this->telefono,true);
		$criteria->compare('fecha_instalacion',$this->fecha_instalacion,true);
		$criteria->compare('servidorId',$this->servidorId);
		$criteria->compare('repetidorId',$this->repetidorId);
		$criteria->compare('nivel_senal',$this->nivel_senal);
		$criteria->compare('ip_lan',$this->ip_lan,false);
		$criteria->compare('ip_antena',$this->ip_antena,false);
		$criteria->compare('equipoId',$this->equipoId);
		$criteria->compare('cicloId',$this->cicloId);
		$criteria->compare('clienteId',$this->clienteId);
		$criteria->compare('costoServicio',$this->costoServicio,true);
		$criteria->compare('planId',$this->planId);
		$criteria->compare('barrioId',$this->barrioId);

		return new CActiveDataProvider(get_class($this), array(
			'criteria'=>$criteria,
		));
	}

	

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
	 */
	public function getPeriodosImpagos() {
        // Warning: Please modify the following code to remove attributes that
        // should not be searched.
        $criteria = new CDbCriteria;
        $criteria->addCondition('servicioId='.$this->id);
        $criteria->addCondition('estado=0');
        $criteria->addCondition("fechaVencimiento<='".date('Y-m-d')."'");
        return count(NotaVenta::model()->findAll($criteria));
    }

}