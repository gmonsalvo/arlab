<?php

/**
 * This is the model class for table "recibos".
 *
 * The followings are the available columns in table 'recibos':
 * @property integer $id
 * @property integer $sucursal
 * @property integer $numero
 * @property string $fecha
 * @property integer $clienteId
 * @property string $detalle
 * @property string $montoTotal
 * @property string $userStamp
 * @property string $timeStamp
 */
class Recibos extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @return Recibos the static model class
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
		return 'recibos';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('fecha, clienteId, montoTotal, timeStamp', 'required'),
			array('sucursal, numero, clienteId', 'numerical', 'integerOnly'=>true),
			array('montoTotal', 'length', 'max'=>15),
			array('userStamp', 'length', 'max'=>50),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, sucursal, numero, fecha, clienteId, montoTotal, userStamp, timeStamp', 'safe', 'on'=>'search'),
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
		'cliente' => array(self::BELONGS_TO, 'Clientes', 'clienteId'),
		'formaPago' => array(self::HAS_MANY, 'FormaPagoRecibos', 'reciboId'),
		'RecibosNotaVenta'=>array(self::HAS_MANY, 'RecibosNotaVenta','reciboId'),
		'totalRecibosNotaVenta' => array(self::STAT, 'RecibosNotaVenta', 'reciboId','select'=> 'SUM(monto+recargo)'),
		'totalFormaPago' => array(self::STAT, 'FormaPagoRecibos', 'reciboId','select'=> 'SUM(monto)'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'sucursal' => 'Sucursal',
			'numero' => 'Numero',
			'fecha' => 'Fecha',
			'clienteId' => 'Cliente',
			'recargo' => 'Recargo',
			'montoTotal' => 'Monto Total',
			'userStamp' => 'Creado por',
			'timeStamp' => 'Fecha Creacion',
		);
	}

	protected function beforeValidate()
	{
            $this->timeStamp = Date("Y-m-d h:m:s");
            return parent::beforeValidate();
	}
	/*
	public function getTotalRecibosNotaVenta()
	{
	  $totalSQL = "SELECT SUM(rnv.monto) FROM recibosNotaVenta rnv WHERE reciboId='".$this->id."' ";
      $total = Yii::app()->db->createCommand($totalSQL)->queryScalar();
	  return $total;
	}*/
	
	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
	 */
	/*
        public function behaviors()
	{
		return array('datetimeI18NBehavior2' => array('class' => 'ext.DateTimeI18NBehavior2'));
	}
      */  
	public function search()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('id',$this->id);
		$criteria->compare('sucursal',$this->sucursal);
		$criteria->compare('numero',$this->numero);
		$criteria->compare('fecha',$this->fecha,true);
		$criteria->compare('clienteId',$this->clienteId);
		$criteria->compare('montoTotal',$this->montoTotal,true);
		$criteria->compare('userStamp',$this->userStamp,true);
		$criteria->compare('timeStamp',$this->timeStamp,true);
                $criteria->compare('estado',1,true);
                $criteria->order='fecha desc,numero desc';

		return new CActiveDataProvider(get_class($this), array(
			'criteria'=>$criteria,
		));
	}

	public static function getUltimoNumero($sucursal) {
     return Yii::app()->db->createCommand()
    ->select('ultimoNumero')
    ->from('documentos')
    ->where('tipoDocumento="REC" AND sucursal='.$sucursal)
    ->queryScalar();
	}
}