<?php

/**
 * This is the model class for table "notaVenta".
 *
 * The followings are the available columns in table 'notaVenta':
 * @property string $id
 * @property string $fecha
 * @property string $detalle
 * @property string $fechaVencimiento
 * @property integer $clienteId
 * @property integer $periodo
 * @property integer $estado
 * @property string $userStamp
 * @property string $timeStamp
 */
class NotaVenta extends CActiveRecord
{

    const ESTADO_IMPAGO = 0;
    const ESTADO_PAGADO = 1;
    const RECARGO_FIJO = 15;
    public $saldo;
	/**
	 * Returns the static model of the specified AR class.
	 * @return NotaVenta the static model class
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
		return 'notaVenta';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('fecha, detalle, clienteId,monto,periodo', 'required'),
			array('clienteId, periodo', 'numerical', 'integerOnly'=>true),
			array('monto', 'numerical'),
                        array('periodo', 'length','max'=>6),
			array('detalle', 'length', 'max'=>5000),
			array('userStamp', 'length', 'max'=>50),
			array('fechaVencimiento, timeStamp', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, fecha, detalle, fechaVencimiento, clienteId, periodo, estado, userStamp, timeStamp,monto', 'safe', 'on'=>'search'),
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
			'ctaCte' => array(self::HAS_MANY, 'CtaCteClientes', 'notaVentaId'),
            'facturas'=>array(self::MANY_MANY, 'Facturas','facturasNotaVenta(notaVentaId,facturaId)'),
		);

	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */

    protected function beforeValidate()
	{
            $this->timeStamp = Date("Y-m-d h:m:s");
            return parent::beforeValidate();
	}

	public function getDetalleCompleto(){
		return $this->detalle . ' Periodo:' . $this->periodo.' - Fecha Vencimiento:'. $this->fechaVencimiento.' -Monto Origen:'.$this->monto.' -Saldo:'.$this->getSaldo();
	}

	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'fecha' => 'Fecha',
			'detalle' => 'Detalle',
			'fechaVencimiento' => 'Fecha Vencimiento',
			'clienteId' => 'Cliente',
			'periodo' => 'Periodo',
			'monto' => 'Monto',
			'estado' => 'Estado',
			'userStamp' => 'User Stamp',
			'timeStamp' => 'Time Stamp',
		);
	}

        public function getSaldo() {

        $debitoSQL = "SELECT SUM(c.monto) FROM notaVenta nv INNER JOIN ctaCteClientes c ON (c.notaVentaId=nv.id) WHERE nv.id='".$this->id."' AND c.tipoMov=0";
        $debitoQRY = Yii::app()->db->createCommand($debitoSQL)->queryScalar();
        $creditoSQL = "SELECT SUM(c.monto) FROM notaVenta nv INNER JOIN ctaCteClientes c ON (c.notaVentaId=nv.id) WHERE nv.id='".$this->id."' AND c.tipoMov=1";
        $creditoQRY = Yii::app()->db->createCommand($creditoSQL)->queryScalar();
        $this->saldo=number_format($debitoQRY-$creditoQRY,2);
        return $this->saldo;

        }
        public function getSaldoNoFormat() {

        $debitoSQL = "SELECT SUM(c.monto) FROM notaVenta nv INNER JOIN ctaCteClientes c ON (c.notaVentaId=nv.id) WHERE nv.id='".$this->id."' AND c.tipoMov=0";
        $debitoQRY = Yii::app()->db->createCommand($debitoSQL)->queryScalar();
        $creditoSQL = "SELECT SUM(c.monto) FROM notaVenta nv INNER JOIN ctaCteClientes c ON (c.notaVentaId=nv.id) WHERE nv.id='".$this->id."' AND c.tipoMov=1";
        $creditoQRY = Yii::app()->db->createCommand($creditoSQL)->queryScalar();
        $this->saldo=round($debitoQRY-$creditoQRY,2);
        return $this->saldo;

        }

        public function getSaldoSinIva() {

        $debitoSQL = "SELECT SUM(c.monto) FROM notaVenta nv INNER JOIN ctaCteClientes c ON (c.notaVentaId=nv.id) WHERE nv.id='".$this->id."' AND c.tipoMov=0";
        $debitoQRY = Yii::app()->db->createCommand($debitoSQL)->queryScalar();
        $creditoSQL = "SELECT SUM(c.monto) FROM notaVenta nv INNER JOIN ctaCteClientes c ON (c.notaVentaId=nv.id) WHERE nv.id='".$this->id."' AND c.tipoMov=1";
        $creditoQRY = Yii::app()->db->createCommand($creditoSQL)->queryScalar();
        $this->saldo=round(($debitoQRY-$creditoQRY)/1.21,2);
        return $this->saldo;

        }
        public function setSaldo($valor){

            $this->saldo=$valor;
        }

        public function debitoGenerado($clienteId,$periodo,$monto)
        {

          return $this->exists('clienteId = :clienteId AND periodo =:periodo AND monto=:monto',
                  array(':clienteId'=>$clienteId, ':periodo'=>$periodo,':monto'=>$monto));

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
		$criteria->compare('fecha',$this->fecha,true);
		$criteria->compare('detalle',$this->detalle,true);
		$criteria->compare('fechaVencimiento',$this->fechaVencimiento,true);
		$criteria->compare('clienteId',$this->clienteId);
		$criteria->compare('periodo',$this->periodo);
		$criteria->compare('estado',$this->estado);
		$criteria->compare('userStamp',$this->userStamp,true);
		$criteria->compare('timeStamp',$this->timeStamp,true);

		return new CActiveDataProvider(get_class($this), array(
			'criteria'=>$criteria,
		));
	}


        public function searchImpagas($clienteId)
	{
		$criteria=new CDbCriteria;
		$criteria->compare('clienteId',$clienteId);
                $criteria->addNotInCondition('id', array('14513','14696'));
                $criteria->order="periodo";
		return new CActiveDataProvider(get_class($this), array(
			'criteria'=>$criteria,
                        'pagination'=>false
		));
	}

        public function behaviors()
	{
		return array('datetimeI18NBehavior2' => array('class' => 'ext.DateTimeI18NBehavior2'));
	}

	/**
	 * Chequea si la nota de venta tiene conceptoId=14 (Recargo por mora) en ctaCteClientes
	 * @return [boolean] [true si ya tiene recargo]
	 */
	public function tieneRecargo(){
		$criteria =  new CDbCriteria();
		$criteria->condition = "notaVentaId=:notaVentaId AND conceptoId=14";
		$criteria->params = array(":notaVentaId"=>$this->id);
		return CtaCteClientes::model()->exists($criteria);
	}
}