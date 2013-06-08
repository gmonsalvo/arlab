<?php

/**
 * This is the model class for table "Clientes".
 *
 * The followings are the available columns in table 'Clientes':
 * @property integer $id
 * @property string $razonSocial
 * @property integer $condicionIvaId
 * @property string $direccion
 * @property string $cuit
 * @property string $telefono
 * @property string $interno
 * @property string $mail
 * @property string $web
 * @property string $infoAdicional
 * @property integer $ciudadId
 *
 * The followings are the available model relations:
 * @property CondicionesIva $condicionIva
 * @property Ciudades $ciudad
 * @property GestionesAdministracion[] $gestionesAdministracions
 * @property ServiciosInternet[] $serviciosInternets
 * @property Soportes[] $soportes
 */
class Clientes extends CActiveRecord
{
     const ESTADO_ACTIVO=0;
     const ESTADO_SUSPENDIDO=1;
     const ESTADO_BAJA=2;
     public $saldo=0;
    
        /**
	 * Returns the static model of the specified AR class.
	 * @return Clientes the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}



    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return 'Clientes';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('condicionIvaId, ciudadId,barrioId,provinciaId,cuentaOrden,notificacionesElectronicas', 'required'),
            array('condicionIvaId, ciudadId,cobradorId', 'numerical', 'integerOnly' => true),
            array('razonSocial, direccion', 'length', 'max' => 255),
            array('cuit', 'length', 'max' => 13),
            array('cuit', 'unique'),
            array('telefono, mail, web', 'length', 'max' => 100),
            array('interno', 'length', 'max' => 15),
            array('infoAdicional', 'length', 'max' => 254),
            array('codigoPagoElectronico', 'length', 'max' => 15),
            // The following rule is used by search().
            // Please remove those attributes that should not be searched.
            array('id, razonSocial, condicionIvaId, direccion, cuit, telefono, interno, mail, web, infoAdicional,codigoPagoElectronico,ciudadId', 'safe', 'on' => 'search'),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations() {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array(
            'condicionIva' => array(self::BELONGS_TO, 'CondicionesIva', 'condicionIvaId'),
            'ciudad' => array(self::BELONGS_TO, 'Ciudades', 'ciudadId'),
            'barrio' => array(self::BELONGS_TO, 'Barrios', 'barrioId'),
            'gestiones' => array(self::HAS_MANY, 'Gestiones', 'clienteId'),
            'serviciosInternets' => array(self::HAS_MANY, 'ServiciosInternet', 'clienteId'),
            'serviciosVoip' => array(self::HAS_MANY, 'ServiciosVoip', 'clienteId'),
            'soportes' => array(self::HAS_MANY, 'Soportes', 'clienteId'),
            'cobrador' => array(self::BELONGS_TO, 'Cobradores', 'cobradorId'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        return array(
            'id' => 'ID',
            'razonSocial' => 'Razon Social',
            'condicionIvaId' => 'Condicion Ante el Iva',
            'CuentaOrden' => 'Por cuenta y Orden',
            'codigoPagoElectronico' => 'Cod. Pago Electronico',
            'direccion' => 'Direccion',
            'cuit' => 'CUIT/DNI/CUIL',
            'telefono' => 'Telefonos',
            'interno' => 'Interno VOIP',
            'mail' => 'Mail',
            'web' => 'Web',
            'infoAdicional' => 'Info Adicional',
            'cuentaOrden' => 'Fact. Por Cuenta y Orden',
            'ciudadId' => 'Ciudad',
            'barrioId' => 'Barrio',
            'provinciaId' => 'Provincia',
            'userStamp' => 'Creador Por',
            'createStamp' => 'Fecha Creacion',
            'lastUpdateStamp' => 'Fecha Ult. Modificacion',
            'lastUserUpdate' => 'Ult. Modificacion',
        );
    }

    public function getSaldo($fechaVencimiento = null) {

//            $ctaCte=new CtacteClientes;
//            $ctaCte->clienteId=$this->id;
//            $ctaCte->productoId=0;
//            $this->saldo=$ctaCte->getSaldo();
        if (!isset($fechaVencimiento))
            $fechaVencimiento = date("Y-m-d");
        $debitoSQL = "SELECT SUM(c.monto) FROM notaVenta nv INNER JOIN ctaCteClientes c ON (c.notaVentaId=nv.id) WHERE clienteId='" . $this->id . "' AND c.tipoMov=0 and fechaVencimiento<='" . $fechaVencimiento . "'";
        $debitoQRY = Yii::app()->db->createCommand($debitoSQL)->queryScalar();
        $creditoSQL = "SELECT SUM(c.monto) FROM notaVenta nv INNER JOIN ctaCteClientes c ON (c.notaVentaId=nv.id) WHERE clienteId='" . $this->id . "' AND c.tipoMov=1 and fechaVencimiento<='" . $fechaVencimiento . "'";
        $creditoQRY = Yii::app()->db->createCommand($creditoSQL)->queryScalar();
        $this->saldo= $debitoQRY-$creditoQRY;
        return $this->saldo;
        
    }

    public function getSaldoMorosos($id, $fechaVencimiento = null) {

//            $ctaCte=new CtacteClientes;
//            $ctaCte->clienteId=$this->id;
//            $ctaCte->productoId=0;
//            $this->saldo=$ctaCte->getSaldo();
    if (!isset($fechaVencimiento))
            $fechaVencimiento = date("Y-m-d");
        $debitoSQL = "SELECT SUM(c.monto) FROM notaVenta nv INNER JOIN ctaCteClientes c ON (c.notaVentaId=nv.id) WHERE clienteId='" . $id . "' AND c.tipoMov=0 and fechaVencimiento<='" . $fechaVencimiento . "'";
        $debitoQRY = Yii::app()->db->createCommand($debitoSQL)->queryScalar();
        $creditoSQL = "SELECT SUM(c.monto) FROM notaVenta nv INNER JOIN ctaCteClientes c ON (c.notaVentaId=nv.id) WHERE clienteId='" . $id . "' AND c.tipoMov=1 and fechaVencimiento<='" . $fechaVencimiento . "'";
        $creditoQRY = Yii::app()->db->createCommand($creditoSQL)->queryScalar();
        return $debitoQRY - $creditoQRY;
    }

    public function getEstados() {
        return array(
            self::ESTADO_ACTIVO => 'ACTIVO',
            self::ESTADO_SUSPENDIDO => 'SUSPENDIDO',
            self::ESTADO_BAJA => 'DADO DE BAJA',
        );
    }

    public function getEstadosDescripcion() {
        $options = array();
        $options = $this->getEstados();
        return $options[$this->tipoCliente];
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
        $criteria->compare('razonSocial', $this->razonSocial, true);
        $criteria->compare('condicionIvaId', $this->condicionIvaId);
        $criteria->compare('codigoPagoElectronico', $this->codigoPagoElectronico,true);
        $criteria->compare('direccion', $this->direccion, true);
        $criteria->compare('cuit', $this->cuit, true);
        $criteria->compare('telefono', $this->telefono, true);
        $criteria->compare('interno', $this->interno, true);
        $criteria->compare('mail', $this->mail, true);
        $criteria->compare('web', $this->web, true);
        $criteria->compare('infoAdicional', $this->infoAdicional, true);
        $criteria->compare('ciudadId', $this->ciudadId);
        $criteria->compare('ciudadId', $this->cuentaOrden);

        return new CActiveDataProvider(get_class($this), array(
                    'criteria' => $criteria,
                ));
    }

     public function searchSuspendidos() {
        // Warning: Please modify the following code to remove attributes that
        // should not be searched.

        $criteria = new CDbCriteria;

        $criteria->compare('id', $this->id);
        $criteria->compare('razonSocial', $this->razonSocial, true);
        $criteria->compare('condicionIvaId', $this->condicionIvaId);
        $criteria->compare('codigoPagoElectronico', $this->codigoPagoElectronico,true);
        $criteria->compare('direccion', $this->direccion, true);
        $criteria->compare('cuit', $this->cuit, true);
        $criteria->compare('telefono', $this->telefono, true);
        $criteria->compare('interno', $this->interno, true);
        $criteria->compare('mail', $this->mail, true);
        $criteria->compare('web', $this->web, true);
        $criteria->compare('infoAdicional', $this->infoAdicional, true);
        $criteria->compare('ciudadId', $this->ciudadId);
        $criteria->compare('cuentaOrden', $this->cuentaOrden);
        $criteria->compare('estado', self::ESTADO_SUSPENDIDO);

        return new CActiveDataProvider(get_class($this), array(
                    'criteria' => $criteria,
                ));
    }

     public function getActivos() {
        // Warning: Please modify the following code to remove attributes that
        // should not be searched.

        $criteria = new CDbCriteria;
        $criteria->compare('estado',self::ESTADO_ACTIVO);
        return $this->findAll($criteria);
    }

    public function getServiciosInternet() {
        // Warning: Please modify the following code to remove attributes that
        // should not be searched.
        $criteria = new CDbCriteria;
        $criteria->compare('clienteId',$this->id);
        return ServiciosInternet::model()->findAll($criteria);
    }


    public function getCodigoPagoDineroMail()
    {
     $criteria = new CDbCriteria;
     $criteria->select = 't.*';
     $criteria->join  =' INNER JOIN notaVenta nv ON nv.id = t.notaVentaId';
     $criteria->condition = ' nv.clienteId = :value';
     $criteria->params = array(":value" =>$cliente->id );
     $criteria->order= "periodo,tipoMov,fecha";

    }
    public function getReporteMorosos($fechaVencimiento, $cantidadPeriodos) {
        $criteria = new CDbCriteria;
        $command = Yii::app()->db->createCommand();
        $resultados = $command->select(array('c.id', 'c.razonSocial', 'morosos.cantidad_periodos','c.ciudadId','c.estado'))
                ->from('Clientes c')
                ->join('(SELECT clienteId,COUNT(*) AS cantidad_periodos FROM 
                        (SELECT periodo,clienteId FROM notaVenta 
                        WHERE estado=0 AND monto>0
                        AND fechaVencimiento<="' . $fechaVencimiento . '"
                        GROUP BY periodo,clienteId
                        ORDER BY clienteId) AS resultados
                        GROUP BY clienteId
                        HAVING COUNT(*) >=' . $cantidadPeriodos . '
                        ORDER BY COUNT(*)) AS morosos', 'c.id=morosos.clienteId')
                ->where('estado<>2')
                ->order(array('razonSocial', 'cantidad_periodos'))
                ->queryAll();
        $rawData = array();
        foreach ($resultados as $resultado) {
            $estado="";
            if ($resultado["estado"]==0){
                $estado="ACTIVO";
            }
            if ($resultado["estado"]==1){
                $estado="SUSPENDIDO";
            }
            if ($resultado["estado"]==2){
                $estado="BAJA";
            }
            array_push($rawData, array(
                'id' => $resultado["id"],
                'razonSocial' => $resultado["razonSocial"],
                'ciudadId' => $resultado["ciudadId"],
                'periodosAdeudados' => $resultado["cantidad_periodos"],
                'saldo' => 0,
                'estadoCliente' => $estado,
                'fechaVencimiento'=>  $fechaVencimiento
            ));
        }
        $arrayDataProvider = new CArrayDataProvider($rawData, array(
                    'id' => 'id',
                    'pagination' => array(
                        'pageSize' => 10,
                    ),
                ));
        return $arrayDataProvider;
        //return var_dump($resultados);
    }

}