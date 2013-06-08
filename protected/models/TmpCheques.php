<?php

/**
 * This is the model class for table "tmpCheques".
 *
 * The followings are the available columns in table 'tmpCheques':
 * @property string $id
 * @property string $tasaDescuento
 * @property integer $clearing
 * @property string $pesificacion
 * @property string $numeroCheque
 * @property integer $libradorId
 * @property integer $bancoId
 * @property string $montoOrigen
 * @property string $fechaPago
 * @property integer $tipoCheque
 * @property string $endosante
 * @property string $montoNeto
 * @property integer $estado
 * @property string $userStamp
 * @property string $timeStamp
 * @property integer $sucursalId
 */
class TmpCheques extends CActiveRecord {
    /**
     * Returns the static model of the specified AR class.
     * @return TmpCheques the static model class
     */
    //Tipo del cheque 
    const TYPE_VENTANILLA=0;
    const TYPE_CRUZADO=1;
    const TYPE_NO_A_LA_ORDEN=2;
    const TYPE_A_LEVANTAR=3;

    //Estado del cheque
    const TYPE_EN_CARTERA_SIN_COLOCAR=0;
    const TYPE_RECHAZADO=1;
    const TYPE_EN_CLIENTE_INVERSOR=2;
    const TYPE_VENDIDO=3;
    const TYPE_EN_CARTERA_COLOCADO=4;
    const TYPE_EN_PESIFICADOR=5;

    const NUMERO_DECIMALES=2;

    private $descuentoTasa;
    private $descuentoPesific;

    public static function model($className=__CLASS__) {
        return parent::model($className);
    }

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return 'tmpCheques';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('tasaDescuento, libradorId, bancoId, montoOrigen, fechaPago, estado, userStamp, timeStamp, sucursalId, numeroCheque, montoNeto', 'required'),
            array('clearing, libradorId, bancoId, tipoCheque, estado, sucursalId, numeroCheque', 'numerical', 'integerOnly' => true),
            array('tasaDescuento, pesificacion', 'length', 'max' => 5),
            array('numeroCheque', 'length', 'max' => 45),
            array('montoOrigen, montoNeto', 'length', 'max' => 15),
            array('endosante', 'length', 'max' => 100),
            //array('timeStamp', 'default', 'value'=>date("d-m-Y h:m:s"),'setOnEmpty'=>false,'on'=>'insert'),
            array('fechaPago, timeStamp', 'safe'),
            array('numeroCheque', 'validateCheque'),
            // The following rule is used by search().
            // Please remove those attributes that should not be searched.
            array('id, tasaDescuento, clearing, pesificacion, numeroCheque, libradorId, bancoId, montoOrigen, fechaPago, tipoCheque, endosante, montoNeto, estado, userStamp, timeStamp, sucursalId', 'safe', 'on' => 'search'),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations() {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array(
            'banco' => array(self::BELONGS_TO, 'Bancos', 'bancoId'),
            'librador' => array(self::BELONGS_TO, 'Libradores', 'libradorId'),
            'sucursal' => array(self::BELONGS_TO, 'Sucursales', 'sucursalId'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        return array(
            'id' => 'ID',
            'tasaDescuento' => 'Tasa Descuento',
            'clearing' => 'Clearing',
            'pesificacion' => 'Pesificacion',
            'numeroCheque' => 'Numero Cheque',
            'libradorId' => 'Librador',
            'bancoId' => 'Banco',
            'montoOrigen' => 'Monto Origen',
            'fechaPago' => 'Fecha Pago',
            'tipoCheque' => 'Tipo Cheque',
            'endosante' => '2do Endoso',
            'montoNeto' => 'Monto Neto',
            'estado' => 'Estado',
            'userStamp' => 'User Stamp',
            'timeStamp' => 'Time Stamp',
            'sucursalId' => 'Sucursal',
        );
    }

    /**
     * Retrieves a list of models based on the current search/filter conditions.
     * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
     */
    public function search() {
        // Warning: Please modify the following code to remove attributes that
        // should not be searched.

        $criteria = new CDbCriteria;

        $criteria->compare('id', $this->id, true);
        $criteria->compare('tasaDescuento', $this->tasaDescuento, true);
        $criteria->compare('clearing', $this->clearing);
        $criteria->compare('pesificacion', $this->pesificacion, true);
        $criteria->compare('numeroCheque', $this->numeroCheque, true);
        $criteria->compare('libradorId', $this->libradorId);
        $criteria->compare('bancoId', $this->bancoId);
        $criteria->compare('montoOrigen', $this->montoOrigen, true);
        $criteria->compare('fechaPago', $this->fechaPago, true);
        $criteria->compare('tipoCheque', $this->tipoCheque);
        $criteria->compare('endosante', $this->endosante, true);
        $criteria->compare('montoNeto', $this->montoNeto, true);
        $criteria->compare('estado', $this->estado);
        $criteria->compare('userStamp', $this->userStamp, true);
        $criteria->compare('timeStamp', $this->timeStamp, true);
        $criteria->compare('sucursalId', $this->sucursalId);

        return new CActiveDataProvider($this, array(
                    'criteria' => $criteria,
                ));
    }

    public function searchByUserName() {
        // Warning: Please modify the following code to remove attributes that
        // should not be searched.

        $criteria = new CDbCriteria;
        $criteria->condition = "t.userStamp='" . Yii::app()->user->model->username . "' AND DATE(t.timeStamp)='" . Date('Y-m-d') . "'";
        $criteria->order = ' t.timeStamp DESC';
        //$criteria->compare('userStamp',Yii::app()->user->model->username);
        //$criteria->compare('DATE.(timeStamp)',Date('Y-m-d'));

        return new CActiveDataProvider($this, array(
                    'criteria' => $criteria,
                ));
    }

    public function searchByUserName2() {
        // Warning: Please modify the following code to remove attributes that
        // should not be searched.

        $criteria = new CDbCriteria;
        $criteria->condition = "t.userStamp='" . Yii::app()->user->model->username . "' AND DATE(t.timeStamp)='" . Date('Y-m-d') . "'";
        $criteria->order = ' t.timeStamp DESC';
        //$criteria->compare('userStamp',Yii::app()->user->model->username);
        //$criteria->compare('DATE.(timeStamp)',Date('Y-m-d'));

        return $this->findAll($criteria);
    }

    protected function beforeValidate() {
        $this->estado = self::TYPE_EN_CARTERA_SIN_COLOCAR;
        $this->sucursalId = Yii::app()->user->model->sucursalId;
        $this->userStamp = Yii::app()->user->model->username;
        $this->timeStamp = new CDbExpression('NOW()');
        //if ($this->isNewRecord)
        //$this->timeStamp = date("d-m-Y h:m:s");
        return parent::beforeValidate();
    }

    public function behaviors() {
        return array('datetimeI18NBehavior' => array('class' => 'ext.DateTimeI18NBehavior')); // 'ext' is in Yii 1.0.8 version. For early versions, use 'application.extensions' instead.
    }

    public function getTypeOptions($type) {
        switch ($type) {
            case 'tipoCheque':
                return array(
                    self::TYPE_VENTANILLA => 'Ventanilla',
                    self::TYPE_CRUZADO => 'Cruzado',
                    self::TYPE_NO_A_LA_ORDEN => 'No a la orden',
                    self::TYPE_A_LEVANTAR => 'A levantar',
                );
            case 'estado':
                return array(
                    self::TYPE_EN_CARTERA_SIN_COLOCAR => 'En cartera sin colocar',
                    self::TYPE_RECHAZADO => 'Rechazado',
                    self::TYPE_EN_CLIENTE_INVERSOR => 'En cliente inversor',
                    self::TYPE_VENDIDO => 'Vendido',
                    self::TYPE_EN_CARTERA_COLOCADO => 'En cartera colocado',
                    self::TYPE_EN_PESIFICADOR => 'En pesificador',
                );
            default:
                return array();
        }
    }

    public function getTypeDescription($type) {
        $options = array();
        $options = $this->getTypeOptions($type);
        return $options[$this->$type];
    }

    public function calcularMontoNeto($montoOrigen, $fechaPago, $tasaDescuento, $clearing, $pesificacion, $fechaOperacion) {
        $dFecIni = Date("d-m-Y");
        if ($fechaPago == $fechaOperacion) { //si la fecha de pago es la del dia de hoy es un cheque corriente corresponde solo gastos de pesificacion
            $descuentoPesific = ($pesificacion / 100) * $montoOrigen;
            $resultado = $montoOrigen - $descuentoPesific;
            $descuentoTasa = 0;
        } else {
            $dFecFin = $fechaPago;
            $dFecIni = str_replace("-", "", $dFecIni);
            $dFecIni = str_replace("/", "", $dFecIni);
            $dFecFin = str_replace("-", "", $dFecFin);
            $dFecFin = str_replace("/", "", $dFecFin);

            ereg("([0-9]{1,2})([0-9]{1,2})([0-9]{2,4})", $dFecIni, $aFecIni);
            ereg("([0-9]{1,2})([0-9]{1,2})([0-9]{2,4})", $dFecFin, $aFecFin);

            $date1 = mktime(0, 0, 0, $aFecIni[2], $aFecIni[1], $aFecIni[3]);
            $date2 = mktime(0, 0, 0, $aFecFin[2], $aFecFin[1], $aFecFin[3]);

            $dias = round(($date2 - $date1) / (60 * 60 * 24));

            $C = $montoOrigen;
            $n = $dias + $clearing;
            $i = $tasaDescuento;
            //$divisor=pow(1+($i/100),$n);
            $this->descuentoPesific = $this->truncateFloat(($pesificacion / 100) * $C, self::NUMERO_DECIMALES);
            $this->descuentoTasa = $this->truncateFloat($C * ((($tasaDescuento / 30) * $n) / 100), self::NUMERO_DECIMALES);
            $resultado = $this->truncateFloat($C - $this->descuentoTasa - $this->descuentoPesific, self::NUMERO_DECIMALES);
        }
        $datos = $resultado . ';' . $this->descuentoTasa . ';' . $this->descuentoPesific;
        return $datos;
        //return $fechaOperacion.' '.$resultado.' '.$n.' '.($C/$divisor).' '.(($pesificacion/100)*$C);	
    }

    public function getDescuentoTasa() {
        return $this->descuentoTasa;
    }

    public function getDescuentoPesific() {
        return $this->descuentoPesific;
    }

    public function afterFind() {
        $this->descuentoTasa = $this->montoOrigen - $this->montoNeto - ($this->pesificacion / 100) * $this->montoOrigen;
        $this->descuentoPesific = ($this->pesificacion / 100) * $this->montoOrigen;
        return parent::afterFind();
    }

    public function validateCheque($attribute, $params) {
        $criteria = new CDbCriteria;
        $criteria->condition = "DATE(t.timeStamp)='" . Date('Y-m-d') . "'";
        //$listaCheques=TmpCheques::findAll($criteria);
        $tmpCheque = new TmpCheques;
        $lista = $tmpCheque->findAll($criteria);
        $cheque = new Cheques;
        $lista2 = $cheque->findAll();
        //valido si existe una combinacion cheque banco cargada en TmpCheques
        if (count($lista) > 0) {
            foreach ($lista as $tcheque) {
                if (($this->numeroCheque == $tcheque->numeroCheque) && ($this->bancoId == $tcheque->bancoId)) {
                    $this->addError($this->numeroCheque, "La combinacion de numero de cheque y el banco ya existe");
                    break;
                }
            }
        }
        if (count($lista2) > 0) {
            foreach ($lista2 as $tcheque) {
                if (($this->numeroCheque == $tcheque->numeroCheque) && ($this->bancoId == $tcheque->bancoId)) {
                    $this->addError($this->numeroCheque, "La combinacion de numero de cheque y el banco ya existe");
                    break;
                }
            }
        }
    }

    public function truncateFloat($number, $digitos) {
        $raiz = 10;
        $multiplicador = pow($raiz, $digitos);
        $resultado = ((int) ($number * $multiplicador)) / $multiplicador;
        return $resultado;
        //return number_format($resultado, $digitos);
    }

}