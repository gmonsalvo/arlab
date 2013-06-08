<?php

/**
 * This is the model class for table "productos".
 *
 * The followings are the available columns in table 'productos':
 * @property integer $id
 * @property string $nombre
 * @property string $descripcion
 * @property string $userStamp
 * @property string $timeStamp
 * @property integer $sucursalId
 *
 * The followings are the available model relations:
 * @property CtacteClientes[] $ctacteClientes
 * @property Sucursales $sucursal
 */
class Productos extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @return Productos the static model class
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
		return 'productos';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('nombre', 'required'),
			array('sucursalId', 'numerical', 'integerOnly'=>true),
			array('nombre, userStamp', 'length', 'max'=>45),
			array('descripcion', 'length', 'max'=>255),
			array('timeStamp', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, nombre, descripcion, userStamp, timeStamp, sucursalId', 'safe', 'on'=>'search'),
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
			'ctacteClientes' => array(self::HAS_MANY, 'CtacteClientes', 'productoId'),
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
			'nombre' => 'Nombre',
			'descripcion' => 'Descripcion',
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
		$criteria->compare('nombre',$this->nombre,true);
		$criteria->compare('descripcion',$this->descripcion,true);
		$criteria->compare('userStamp',$this->userStamp,true);
		$criteria->compare('timeStamp',$this->timeStamp,true);
		$criteria->compare('sucursalId',$this->sucursalId);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
	protected function beforeValidate()
    {
		$this->sucursalId = Yii::app()->user->model->sucursalId;
        $this->userStamp = Yii::app()->user->model->username;
        $this->timeStamp = Date("Y-m-d h:m:s");
        return parent::beforeValidate();
    }
}