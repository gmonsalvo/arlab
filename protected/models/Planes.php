<?php

/**
 * This is the model class for table "planes".
 *
 * The followings are the available columns in table 'planes':
 * @property integer $id
 * @property string $descripcion
 * @property integer $subida
 * @property integer $bajada
 * @property string $costo
 */
class Planes extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @return Planes the static model class
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
		return 'planes';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('descripcion, subida, bajada', 'required'),
			array('subida, bajada', 'numerical', 'integerOnly'=>true),
			array('descripcion', 'length', 'max'=>100),
			array('costo', 'length', 'max'=>15),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, descripcion, subida, bajada, costo', 'safe', 'on'=>'search'),
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
			'descripcion' => 'Descripcion',
			'subida' => 'Subida',
			'bajada' => 'Bajada',
			'costo' => 'Costo',
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
		$criteria->compare('descripcion',$this->descripcion,true);
		$criteria->compare('subida',$this->subida);
		$criteria->compare('bajada',$this->bajada);
		$criteria->compare('costo',$this->costo,true);

		return new CActiveDataProvider(get_class($this), array(
			'criteria'=>$criteria,
		));
	}
}