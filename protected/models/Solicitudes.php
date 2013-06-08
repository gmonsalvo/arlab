<?php

/**
 * This is the model class for table "solicitudes".
 *
 * The followings are the available columns in table 'solicitudes':
 * @property integer $id
 * @property string $fecha
 * @property string $cuit
 * @property string $razonSocial
 * @property integer $condicionIvaId
 * @property string $direccion
 * @property integer $barrioId
 * @property integer $ciudadId
 * @property integer $provinciaId
 * @property string $telefono
 * @property string $mail
 * @property string $infoAdicional
 * @property string $userStamp
 * @property string $timeStamp
 */
class Solicitudes extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @return Solicitudes the static model class
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
		return 'solicitudes';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('fecha, cuit, razonSocial, condicionIvaId, direccion, barrioId, ciudadId, provinciaId, telefono, userStamp, timeStamp', 'required'),
			array('condicionIvaId, barrioId, ciudadId, provinciaId', 'numerical', 'integerOnly'=>true),
			array('cuit', 'length', 'max'=>13),
			array('razonSocial, direccion, telefono', 'length', 'max'=>255),
			array('userStamp', 'length', 'max'=>50),
			array('mail', 'length', 'max'=>254),
			array('infoAdicional', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, fecha, cuit, razonSocial, condicionIvaId, direccion, barrioId, ciudadId, provinciaId,telefono, mail, infoAdicional, userStamp, timeStamp', 'safe', 'on'=>'search'),
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
            'barrio' => array(self::BELONGS_TO, 'Barrios', 'barrioId'),
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
			'cuit' => 'DNI/CUIT',
			'razonSocial' => 'Razon Social',
			'condicionIvaId' => 'Condidicion Iva',
			'direccion' => 'Direccion',
			'barrioId' => 'Barrio',
			'ciudadId' => 'Ciudad',
			'provinciaId' => 'Provincia',
			'telefono' => 'Telefono',
			'mail' => 'Mail',
			'infoAdicional' => 'Info Adicional',
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
		$criteria->compare('cuit',$this->cuit,true);
		$criteria->compare('razonSocial',$this->razonSocial,true);
		$criteria->compare('condicionIvaId',$this->condicionIvaId);
		$criteria->compare('direccion',$this->direccion,true);
		$criteria->compare('barrioId',$this->barrioId);
		$criteria->compare('ciudadId',$this->ciudadId);
		$criteria->compare('provinciaId',$this->provinciaId);
	
		$criteria->compare('telefono',$this->telefono,true);
		$criteria->compare('mail',$this->mail,true);
		$criteria->compare('infoAdicional',$this->infoAdicional,true);
		$criteria->compare('userStamp',$this->userStamp,true);
		$criteria->compare('timeStamp',$this->timeStamp,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}