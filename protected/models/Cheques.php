<?php

/**
 * This is the model class for table "cheques".
 *
 * The followings are the available columns in table 'cheques':
 * @property integer $id
 * @property integer $operacionChequeId
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
 *
 * The followings are the available model relations:
 * @property Bancos $banco
 * @property Libradores $librador
 * @property OperacionesCheques $operacionCheque
 * @property Sucursales $sucursal
 */
class Cheques extends CActiveRecord {
    //Tipo de cheque
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
    /**
     * Returns the static model of the specified AR class.
     * @return Cheques the static model class
     */
    //usadas para hacer filtros en las busquedas, no tienen persistencia 
    public $fechaIni, $fechaFin;

    public static function model($className=__CLASS__) {
        return parent::model($className);
    }

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return 'cheques';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('operacionChequeId, tasaDescuento, libradorId, bancoId, montoOrigen, fechaPago, estado, userStamp, timeStamp, sucursalId', 'required'),
            array('operacionChequeId, clearing, libradorId, bancoId, tipoCheque, estado, sucursalId', 'numerical', 'integerOnly' => true),
            array('tasaDescuento, pesificacion', 'length', 'max' => 7),
            array('numeroCheque', 'length', 'max' => 45),
            array('montoOrigen, montoNeto, montoGastos', 'length', 'max' => 15),
            array('endosante', 'length', 'max' => 100),
            array('userStamp', 'length', 'max' => 50),
            // The following rule is used by search().
            // Please remove those attributes that should not be searched.
            array('id, operacionChequeId, tasaDescuento, clearing, pesificacion, numeroCheque, libradorId, bancoId, montoOrigen, fechaPago, tipoCheque, endosante, montoNeto, estado, userStamp, timeStamp, sucursalId, fechaIni, fechaFin', 'safe', 'on' => 'search'),
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
            'operacionCheque' => array(self::BELONGS_TO, 'OperacionesCheques', 'operacionChequeId'),
            'sucursal' => array(self::BELONGS_TO, 'Sucursales', 'sucursalId'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        return array(
            'id' => 'ID',
            'operacionChequeId' => 'Operacion Cheque',
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
            'montoGastos' => 'Monto Gastos',
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

        $criteria->compare('id', $this->id);
        $criteria->compare('operacionChequeId', $this->operacionChequeId);
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

    public function searchByFecha2($fechaIni, $fechaFin) {
        $criteria = new CDbCriteria;
        $this->fechaIni = $fechaIni;
        $this->fechaIni = $fechaFin;
        $criteria->condition = "fechaPago BETWEEN :start_day AND :end_day";
        $criteria->order = 'fechaPago ASC';
        $criteria->params = array(':start_day' => $fechaIni, ':end_day' => $fechaFin);
        //if((isset($this->fechaIni) && trim($this->fechaIni) != "") && (isset($this->fechaFin) && trim($this->fechaFin) != ""))
        //  $criteria->addBetweenCondition('fechaPago', ''.$this->fechaFin.'', ''.$this->fechaFin.'');
        $count = Cheques::model()->count($criteria);
        $pages = new CPagination($count);

        // results per page
        $pages->pageSize = 10;
        //$pages->createPageUrl(new ChequesController,$page);		
        $dataProvider = new CActiveDataProvider(get_class($this), array(
                    'criteria' => $criteria,
                ));
        $dataProvider->setPagination($pages);
        return $dataProvider;
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

    public function listData($models, $valueField, $textFields, $groupField = '') {

        $listData = array();

        foreach ($models as $model) {
            $value = CHtml::value($model, $valueField);
            if (is_array($textFields)) {
                $text = array();
                foreach ($textFields as $attr) {
                    $text[] = CHtml::value($model, $attr);
                }
                $text = implode(' ', $text);
            }
            else
                $text = CHtml::value($model, $textFields);

            if ($groupField === '') {
                $listData[$value] = $text;
            } else {
                $group = CHtml::value($model, $groupField);
                $listData[$group][$value] = $text;
            }
        }
        return $listData;
    }

    public function getFechaIni() {
        return $this->fechaIni;
    }

    public function setFechaIni($value) {
        $this->fechaIni = $value;
    }

    public function getFechaFin() {
        return $this->fechaFin;
    }

    public function setFechaFin($value) {
        $this->fechaFin = $value;
    }

    public function searchChequesByEstado($estado) {
        $criteria = new CDbCriteria;
        $criteria->condition = "estado=:estado";
        $criteria->order = 'fechaPago ASC';
        $criteria->params = array(':estado' => $estado);
        $dataProvider = new CActiveDataProvider(get_class($this), array(
                    'criteria' => $criteria,
                ));
        return $dataProvider;
    }

    public function searchChequesColocadosPorInversor($idCliente) {
        $criteria = new CDbCriteria;
        $criteria->select = "t.*";
        //$criteria->condition = "detalleColocaciones.clienteId='" . $idCliente . "' AND colocaciones.estado='" . Colocaciones::ESTADO_ACTIVA . "' AND colocaciones.id=detalleColocaciones.colocacionId AND t.id=colocaciones.chequeId AND t.estado='" . Cheques::TYPE_EN_CARTERA_COLOCADO . "'";
        
        $criteria->condition = "t.estado='" . Cheques::TYPE_EN_CARTERA_COLOCADO . "' AND t.id IN (SELECT colocaciones.chequeId FROM colocaciones, detalleColocaciones WHERE colocaciones.estado='".Colocaciones::ESTADO_ACTIVA."' AND colocaciones.id=detalleColocaciones.colocacionId AND detalleColocaciones.clienteId='".$idCliente."')";
        $dataProvider = new CActiveDataProvider($this, array(
                    'criteria' => $criteria,
                ));
        return $dataProvider;
    }

    protected function beforeValidate() {
        $this->sucursalId = Yii::app()->user->model->sucursalId;
        $this->userStamp = Yii::app()->user->model->username;
        $this->timeStamp = Date("Y-m-d h:m:s");
        return parent::beforeValidate();
    }

}