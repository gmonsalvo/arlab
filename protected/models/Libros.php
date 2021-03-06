<?php

/**
 * This is the model class for table "libros".
 *
 * The followings are the available columns in table 'libros':
 * @property integer $id
 * @property string $nombre
 * @property integer $tipoLibroId
 *
 * The followings are the available model relations:
 * @property TipoLibros $tipoLibro
 */
class Libros extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @return Libros the static model class
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
		return 'libros';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('tipoLibroId', 'required'),
			array('tipoLibroId', 'numerical', 'integerOnly'=>true),
			array('nombre', 'length', 'max'=>40),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, nombre, tipoLibroId', 'safe', 'on'=>'search'),
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
			'tipoLibro' => array(self::BELONGS_TO, 'TipoLibros', 'tipoLibroId'),
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
			'tipoLibroId' => 'Tipo Libro',
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
		$criteria->compare('tipoLibroId',$this->tipoLibroId);

		return new CActiveDataProvider(get_class($this), array(
			'criteria'=>$criteria,
		));
	}
}