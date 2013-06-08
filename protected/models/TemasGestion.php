<?php

/**
 * This is the model class for table "temasGestion".
 *
 * The followings are the available columns in table 'temasGestion':
 * @property integer $id
 * @property integer $tipoGestionId
 * @property string $descripcion
 * @property string $userStamp
 * @property string $timeStamp
 */
class TemasGestion extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @return TemasGestion the static model class
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
		return 'temasGestion';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('timeStamp', 'required'),
			array('tipoGestionId', 'numerical', 'integerOnly'=>true),
			array('descripcion', 'length', 'max'=>254),
			array('userStamp', 'length', 'max'=>50),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, tipoGestionId, descripcion, userStamp, timeStamp', 'safe', 'on'=>'search'),
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
                       'tipoGestion' => array(self::BELONGS_TO, 'TipoGestiones', 'tipoGestionId'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
        protected function beforeValidate()
	{
            $this->userStamp = Yii::app()->user->model->username;
            $this->timeStamp = Date("Y-m-d h:m:s");
            return parent::beforeValidate();
	}

	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'tipoGestionId' => 'Tipo Gestion',
			'descripcion' => 'Descripcion',
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
		$criteria->compare('tipoGestionId',$this->tipoGestionId);
		$criteria->compare('descripcion',$this->descripcion,true);
		$criteria->compare('userStamp',$this->userStamp,true);
		$criteria->compare('timeStamp',$this->timeStamp,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}