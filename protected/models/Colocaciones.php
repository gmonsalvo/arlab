<?php

/**
 * This is the model class for table "colocaciones".
 *
 * The followings are the available columns in table 'colocaciones':
 * @property integer $id
 * @property string $fecha
 * @property integer $chequeId
 * @property string $montoTotal
 * @property integer $sucursalId
 * @property string $userStamp
 * @property string $timeStamp
 * @property integer $estado
 * @property integer $colocacionAnteriorId
 * The followings are the available model relations:
 * @property Sucursales $sucursal
 * @property Cheques $cheque
 * @property DetalleColocaciones[] $detalleColocaciones
 */
class Colocaciones extends CActiveRecord {
    /**
     * Returns the static model of the specified AR class.
     * @return Colocaciones the static model class
     */
    const ESTADO_INACTIVA = 0;
    const ESTADO_ACTIVA = 1;

    public static function model($className=__CLASS__) {
        return parent::model($className);
    }

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return 'colocaciones';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('fecha, chequeId, montoTotal, sucursalId, userStamp, timeStamp', 'required'),
            array('chequeId, sucursalId, estado, colocacionAnteriorId', 'numerical', 'integerOnly' => true),
            array('montoTotal', 'length', 'max' => 15),
            array('userStamp', 'length', 'max' => 45),
            // The following rule is used by search().
            // Please remove those attributes that should not be searched.
            array('id, fecha, chequeId, montoTotal, sucursalId, userStamp, timeStamp, estado, colocacionAnteriorId', 'safe', 'on' => 'search'),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations() {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array(
            'sucursal' => array(self::BELONGS_TO, 'Sucursales', 'sucursalId'),
            'cheque' => array(self::BELONGS_TO, 'Cheques', 'chequeId'),
            'detalleColocaciones' => array(self::HAS_MANY, 'DetalleColocaciones', 'colocacionId'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        return array(
            'id' => 'ID',
            'fecha' => 'Fecha',
            'chequeId' => 'Cheque',
            'montoTotal' => 'Monto Total',
            'estado' => 'Estado',
            'colocacionAnteriorId' => 'Colocacion anterior',
            'sucursalId' => 'Sucursal',
            'userStamp' => 'User Stamp',
            'timeStamp' => 'Time Stamp',
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
        $criteria->compare('fecha', $this->fecha, true);
        $criteria->compare('chequeId', $this->chequeId);
        $criteria->compare('montoTotal', $this->montoTotal, true);
        $criteria->compare('sucursalId', $this->sucursalId);
        $criteria->compare('userStamp', $this->userStamp, true);
        $criteria->compare('timeStamp', $this->timeStamp, true);

        return new CActiveDataProvider($this, array(
                    'criteria' => $criteria,
                ));
    }

    protected function beforeValidate() {
        $this->sucursalId = Yii::app()->user->model->sucursalId;
        $this->userStamp = Yii::app()->user->model->username;
        $this->timeStamp = Date("Y-m-d h:m:s");
        return parent::beforeValidate();
    }

    public function calculoValorActual($montoOrigen, $fechaFin, $tasa, $clearing) {

        $fechaInicio = Date("d-m-Y");

        $dias = Utilities::RestarFechas($fechaInicio, $fechaFin);
        $C = $montoOrigen;
        $n = $dias + $clearing;
        $i = $tasa / 100;

        $divisor = Utilities::truncateFloat(1 + (($i * $n) / 365), 2);
        $resultado = Utilities::truncateFloat(($C / $divisor), 2);

        return $resultado;
    }

    public function getTypeOptions() {
        return array(
            self::ESTADO_INACTIVA => 'Inactiva',
            self::ESTADO_ACTIVA => 'Activa',
        );
    }

    public function getTypeDescription() {
        $options = array();
        $options = $this->getTypeOptions();
        return $options[$this->tipoCliente];
    }

}
