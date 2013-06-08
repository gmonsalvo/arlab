<?php

/**
 * This is the model class for table "flujoFondos".
 *
 * The followings are the available columns in table 'flujoFondos':
 * @property string $id
 * @property string $fecha
 * @property integer $cuentaId
 * @property integer $tipoMov
 * @property string $monto
 * @property integer $conceptoId
 * @property integer $tipoFondoId
 * @property string $descripcion
 * @property integer $monedaId
 * @property string $userStamp
 * @property string $timeStamp
 *
 * The followings are the available model relations:
 * @property Libros $libro
 * @property Conceptos $concepto
 * @property Monedas $moneda
 * @property Cuentas $cuenta
 * @property TiposFondos $tipoFondo
 */
class FlujoFondos extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @return FlujoFondos the static model class
	 */
	public $periodo;
	public $fechaInicio;
	public $fechaFin;
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'flujoFondos';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('fecha, cuentaId, monto, conceptoId, tipoFondoId, descripcion, monedaId', 'required'),
			array('cuentaId, tipoMov, conceptoId, tipoFondoId, monedaId,periodo', 'numerical', 'integerOnly'=>true),
			array('monto', 'length', 'max'=>15),
			array('descripcion', 'length', 'max'=>255),
			array('userStamp', 'length', 'max'=>50),
			array('timeStamp', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, fecha, cuentaId, tipoMov, monto, conceptoId, tipoFondoId, descripcion, monedaId, userStamp, timeStamp,periodo,fechaInicio,fechaFin', 'safe', 'on'=>'search'),
			array('conceptoId,fechaInicio,fechaFin', 'safe', 'on'=>'searchConceptos'),
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
			'libro' => array(self::BELONGS_TO, 'Libros', 'libroId'),
			'concepto' => array(self::BELONGS_TO, 'ConceptosFlujoFondos', 'conceptoId'),
			'moneda' => array(self::BELONGS_TO, 'Monedas', 'monedaId'),
			'cuenta' => array(self::BELONGS_TO, 'Cuentas', 'cuentaId'),
			'tipoFondo' => array(self::BELONGS_TO, 'TiposFondos', 'tipoFondoId'),
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
			'cuentaId' => 'Cuenta',
			'tipoMov' => 'Tipo Mov',
			'monto' => 'Monto',
			'conceptoId' => 'Concepto',
			'tipoFondoId' => 'Tipo Fondo',
			'descripcion' => 'Descripcion',
			'monedaId' => 'Moneda',
			'userStamp' => 'Usuario',
			'timeStamp' => 'Fecha',
		);
	}

	public function obtenerTipoMov()
	{
		return array(
			'0' => 'Egreso',
			'1' => 'Ingreso',
		
		);
	}

	public function obtenerPeriodos()
	{
		return array(
			'201212' => '2012-12',
			'201301' => '2013-01',
			'201302' => '2013-02',
			'201303' => '2013-03',
			'201304' => '2013-04',
			'201305' => '2013-05',
			'201306' => '2013-06',
			'201307' => '2013-07',
			'201308' => '2013-08',
			'201309' => '2013-09',
			'201310' => '2013-10',
			'201311' => '2013-11',
			'201312' => '2013-12',
		);
	}

    protected function beforeValidate()
	{
            $this->userStamp = Yii::app()->user->model->username;
            $this->timeStamp = Date("Y-m-d h:m:s");
            return parent::beforeValidate();
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
		$criteria->compare('cuentaId',$this->cuentaId);
		$criteria->compare('tipoMov',$this->tipoMov);
		$criteria->compare('monto',$this->monto,true);
		$criteria->compare('conceptoId',$this->conceptoId);
		$criteria->compare('tipoFondoId',$this->tipoFondoId);
		$criteria->compare('descripcion',$this->descripcion,true);
		$criteria->compare('monedaId',$this->monedaId);
		$criteria->compare('userStamp',$this->userStamp,true);
		$criteria->compare('timeStamp',$this->timeStamp,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}


	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
	 */
	public function searchConceptos()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;
		
		$criteria->compare('conceptoId',$this->conceptoId);
		$criteria->addBetweenCondition('fecha',$this->fechaInicio,$this->fechaFin);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
	
	
	public function searchIngresos()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.
		$anio=substr($this->periodo,0,4);
		$mes=substr($this->periodo,4,2);
		$inicio=$anio.'-'.$mes.'-01';
		$fin=$anio.'-'.$mes.'-31';

		$criteria=new CDbCriteria;
		$criteria->addBetweenCondition('fecha',$inicio,$fin);
		$criteria->compare('cuentaId',$this->cuentaId);
		$criteria->compare('tipoMov','1');
		$criteria->order="id DESC";
		
		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	public function searchEgresos()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.
		$anio=substr($this->periodo,0,4);
		$mes=substr($this->periodo,4,2);
		$inicio=$anio.'-'.$mes.'-01';
		$fin=$anio.'-'.$mes.'-31';

		$criteria=new CDbCriteria;
		$criteria->addBetweenCondition('fecha',$inicio,$fin);
		$criteria->compare('cuentaId',$this->cuentaId);
		$criteria->compare('tipoMov','0');
		$criteria->order="id DESC";
		
		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

 	public function searchReporte()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.
		
		$criteria=new CDbCriteria;
		$criteria->addBetweenCondition('fecha',$this->fechaInicio,$this->fechaFin);
		$criteria->compare('cuentaId',$this->cuentaId);
		$criteria->compare('conceptoId',$this->conceptoId);
		$criteria->compare('tipoMov',$this->tipoMov);
		$criteria->order="id DESC";
		
		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	public function getTotals()
    {

      
        $sumaSQL = "SELECT SUM(monto) FROM flujoFondos WHERE conceptoId='".$this->conceptoId."' AND fecha between '" . $this->fechaInicio . "' and '".$this->fechaFin."'";
        $sumaQRY = Yii::app()->db->createCommand($sumaSQL)->queryScalar();
       
        //$this->saldo= $ingresoQRY-$egresoQRY;
        return round($sumaQRY,2);
        
    	


    }

	public function getTotal()
    {

      
        $sumaSQL = "SELECT SUM(monto) FROM flujoFondos WHERE tipoMov='".$this->tipoMov."' AND fecha between '" . $this->fechaInicio . "' and '".$this->fechaFin."' and cuentaId='".$this->cuentaId."' and conceptoId=".$this->conceptoId;
        $sumaQRY = Yii::app()->db->createCommand($sumaSQL)->queryScalar();
       
        //$this->saldo= $ingresoQRY-$egresoQRY;
        return round($sumaQRY,2);
        
    	


    }

    public function getSaldoPeriodo()
    {

        if (isset($this->periodo)) {
        
		$anio=substr($this->periodo,0,4);
		$mes=substr($this->periodo,4,2);
		$inicio=$anio.'-'.$mes.'-01';
		$fin=$anio.'-'.$mes.'-31';

        $egresoSQL = "SELECT SUM(monto) FROM flujoFondos WHERE tipoMov=0 AND fecha between '" . $inicio . "' and '".$fin."' and cuentaId=".$this->cuentaId;
        $egresoQRY = Yii::app()->db->createCommand($egresoSQL)->queryScalar();
        $ingresoSQL = "SELECT SUM(monto) FROM flujoFondos WHERE tipoMov=1 AND fecha between '" . $inicio . "' and '".$fin."' and cuentaId=".$this->cuentaId;
        $ingresoQRY = Yii::app()->db->createCommand($ingresoSQL)->queryScalar();
        //$this->saldo= $ingresoQRY-$egresoQRY;
        return round($ingresoQRY-$egresoQRY,2);
        
    	}


    }

    public function getSaldoPorTipoFondo($tipoFondo,$cuentaId)
    {
    	$periodo=date("Y").date("m");
    	$anio=substr($periodo,0,4);
		$mes=substr($periodo,4,2);
		$inicio=$anio.'-'.$mes.'-01';
		$fin=$anio.'-'.$mes.'-31';

    	$egresoSQL = "SELECT SUM(monto) FROM flujoFondos WHERE tipoMov=0 AND fecha between '" . $inicio . "' and '".$fin."' and cuentaId='".$cuentaId."' and tipoFondoId='".$tipoFondo."'";
	    echo $egresoSQL;
	    $egresoQRY = Yii::app()->db->createCommand($egresoSQL)->queryScalar();
	    $ingresoSQL = "SELECT SUM(monto) FROM flujoFondos WHERE tipoMov=1 AND fecha between '" . $inicio . "' and '".$fin."' and cuentaId='".$cuentaId."' and tipoFondoId='".$tipoFondo."'";
	     echo $ingresoSQL;
	    $ingresoQRY = Yii::app()->db->createCommand($ingresoSQL)->queryScalar();
	    //$this->saldo= $ingresoQRY-$egresoQRY;
	    return round($ingresoQRY-$egresoQRY,2);
    }

    public function getSaldoTiposFondos()
    {


        if (isset($this->periodo)) {
        
		$anio=substr($this->periodo,0,4);
		$mes=substr($this->periodo,4,2);
		$inicio=$anio.'-'.$mes.'-01';
		$fin=$anio.'-'.$mes.'-31';

        $saldosSQL = "select * from (select tf.`nombre`,tipoFondoId as id,sum(ff.`monto`) as subtotalIngreso from flujoFondos ff 
					   inner join tiposFondos tf on (ff.`tipoFondoId`=tf.`id`)
					where fecha between '".$inicio."' and '".$fin."' and ff.`tipoMov`=1 and cuentaId=".$this->cuentaId."
					group by ff.`tipoFondoId` ) ingresos
					left join (
					select tipoFondoId as id,sum(ff.`monto`) as subtotalEgreso from flujoFondos ff 
					inner join tiposFondos tf on (ff.`tipoFondoId`=tf.`id`)
					where fecha between '".$inicio."' and '".$fin."' and ff.`tipoMov`=0 and cuentaId=".$this->cuentaId."
					group by ff.`tipoFondoId` ) egresos on (egresos.id=ingresos.id)";
		//echo "SQL:".$saldosSQL;
        $saldosQRY = Yii::app()->db->createCommand($saldosSQL)->queryAll();
        //$this->saldo= $ingresoQRY-$egresoQRY;
        return $saldosQRY;
        
    	}

    }



}