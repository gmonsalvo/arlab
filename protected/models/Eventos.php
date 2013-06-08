<?php

/**
 * This is the model class for table "eventos".
 *
 * The followings are the available columns in table 'eventos':
 * @property integer $id
 * @property string $fecha
 * @property string $hora
 * @property integer $tipoEvento
 * @property string $observaciones
 * @property string $userStamp
 * @property string $timeStamp
 */
class Eventos extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @return Eventos the static model class
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
		return 'eventos';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('fecha, tipoEvento, userStamp, timeStamp', 'required'),
			array('tipoEvento', 'numerical', 'integerOnly'=>true),
			array('hora', 'length', 'max'=>4),
			array('userStamp', 'length', 'max'=>50),
			array('observaciones', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, fecha, hora, tipoEvento, observaciones, userStamp, timeStamp', 'safe', 'on'=>'search'),
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
			'hora' => 'Hora',
			'tipoEvento' => 'Tipo Evento',
			'observaciones' => 'Observaciones',
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
		$criteria->compare('hora',$this->hora,true);
		$criteria->compare('tipoEvento',$this->tipoEvento);
		$criteria->compare('observaciones',$this->observaciones,true);
		$criteria->compare('userStamp',$this->userStamp,true);
		$criteria->compare('timeStamp',$this->timeStamp,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	public function getInstalaciones($fecha) {
        // Warning: Please modify the following code to remove attributes that
        // should not be searched.

        $criteria = new CDbCriteria;

        $criteria->compare('tipoEvento',1);
        $criteria->compare('fecha',$fecha);
        return $this->findAll($criteria);
    }

    public function getCantidadInstalaciones($fecha) {
        // Warning: Please modify the following code to remove attributes that
        // should not be searched.

        $criteria = new CDbCriteria;

        $criteria->compare('tipoEvento',1);
        $criteria->compare('fecha',$fecha);
        return count($this->findAll($criteria));
    }

    public function getCiudadesInstalaciones($fecha) {
        // Warning: Please modify the following code to remove attributes that
        // should not be searched.

        $criteria = new CDbCriteria;

        $criteria->compare('tipoEvento',1);
        $criteria->compare('fecha',$fecha);
        $eventos=$this->findAll($criteria);
		$i=0;
		$ciudades="";
		foreach ($eventos as $evento) {
			$solicitud=Solicitudes::model()->findByPk($evento->eventoRelacionadoId);
			$ciudades=$ciudades.$solicitud->ciudad->nombre." ";
			if ($i>=2) break;
		}
		return $ciudades;
    }


}