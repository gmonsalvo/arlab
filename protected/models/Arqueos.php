<?php

/**
 * This is the model class for table "arqueos".
 *
 * The followings are the available columns in table 'arqueos':
 * @property string $id
 * @property integer $cuentaId
 * @property string $saldoTotal
 * @property string $valorActualTotal
 * @property string $userStamp
 * @property string $timeStamp
 */
class Arqueos extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @return Arqueos the static model class
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
		return 'arqueos';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('cuentaId, saldoTotal, valorActualTotal, userStamp, timeStamp', 'required'),
			array('cuentaId', 'numerical', 'integerOnly'=>true),
			array('saldoTotal, valorActualTotal', 'length', 'max'=>15),
			array('userStamp', 'length', 'max'=>50),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, cuentaId, saldoTotal, valorActualTotal, userStamp, timeStamp', 'safe', 'on'=>'search'),
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
			'cuentaId' => 'Cuenta',
			'saldoTotal' => 'Saldo Total',
			'valorActualTotal' => 'Valor Actual Total',
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

		$criteria->compare('id',$this->id,true);
		$criteria->compare('cuentaId',$this->cuentaId);
		$criteria->compare('saldoTotal',$this->saldoTotal,true);
		$criteria->compare('valorActualTotal',$this->valorActualTotal,true);
		$criteria->compare('userStamp',$this->userStamp,true);
		$criteria->compare('timeStamp',$this->timeStamp,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}