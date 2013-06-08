<?php

/**
 * This is the model class for table "nodos".
 *
 * The followings are the available columns in table 'nodos':
 * @property integer $id
 * @property string $nombre
 * @property string $ip_wan
 * @property string $ssid
 * @property string $frequencia
 * @property string $ip_lan
 * @property integer $tipo
 *
 * The followings are the available model relations:
 * @property ServiciosInternet[] $serviciosInternets
 * @property ServiciosInternet[] $serviciosInternets1
 */
class Nodos extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @return Nodos the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	public function getGatewayDescripcion(){
		return $this->nombre . ' (' . $this->ip_lan.')';
	}
	
	public function getRepetidorDescripcion(){
		return $this->ssid . ' - ' . $this->nombre.'';
	}
	
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'nodos';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('tipo', 'required'),
			array('tipo', 'numerical', 'integerOnly'=>true),
			array('nombre', 'length', 'max'=>50),
			array('ip_wan, ip_lan', 'length', 'max'=>15),
			array('ssid', 'length', 'max'=>100),
			array('frequencia', 'length', 'max'=>3),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, nombre, ip_wan, ssid, frequencia, ip_lan, tipo', 'safe', 'on'=>'search'),
		);
	}

	public function getFrequencias(){
		return array('24' => '2,4 GHZ', '58' => '5.8 GHZ','0'=>'No Aplica');
	}
	
	public function getTipos(){
		return array('0' => 'Repetidor', '1' => 'Puerta de enlace','2'=>'Puerta de enlace y Repetidor');
	}
	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
			'serviciosInternets' => array(self::HAS_MANY, 'ServiciosInternet', 'servidorId'),
			'serviciosInternets1' => array(self::HAS_MANY, 'ServiciosInternet', 'repetidorId'),
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
			'ip_wan' => 'IP WAN',
			'ssid' => 'SSID',
			'frequencia' => 'Frequencia',
			'ip_lan' => 'IP LAN',
			'tipo' => 'Tipo',
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
		$criteria->compare('ip_wan',$this->ip_wan,true);
		$criteria->compare('ssid',$this->ssid,true);
		$criteria->compare('frequencia',$this->frequencia,true);
		$criteria->compare('ip_lan',$this->ip_lan,true);
		$criteria->compare('tipo',$this->tipo);

		return new CActiveDataProvider(get_class($this), array(
			'criteria'=>$criteria,
		));
	}
}
