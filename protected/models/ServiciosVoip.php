<?php

/**
 * This is the model class for table "serviciosVoip".
 *
 * The followings are the available columns in table 'serviciosVoip':
 * @property integer $id
 * @property string $fechaInstalacion
 * @property string $domicilio
 * @property integer $ciudadId
 * @property integer $clienteId
 * @property integer $cicloId
 * @property integer $minutosLibres
 * @property string $costoServicio
 * @property string $interno
 * @property string $did
 * @property string $sipServer
 * @property string $detalleEquipo
 * @property string $userStamp
 * @property string $timeStamp
 *
 * The followings are the available model relations:
 * @property Ciudades $ciudad
 */
class ServiciosVoip extends CActiveRecord {

    /**
     * Returns the static model of the specified AR class.
     * @return ServiciosVoip the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return 'serviciosVoip';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('fechaInstalacion, ciudadId, clienteId, costoServicio, interno, did, sipServer, userStamp, timeStamp,instaladores', 'required'),
            array('ciudadId, clienteId, cicloId,minutosLibres', 'numerical', 'integerOnly' => true),
            array('domicilio, interno, did, sipServer, userStamp', 'length', 'max' => 45),
            array('costoServicio', 'length', 'max' => 15),
            array('detalleEquipo', 'length', 'max' => 200),
            // The following rule is used by search().
            // Please remove those attributes that should not be searched.
            array('id, fechaInstalacion, domicilio, ciudadId, clienteId, cicloId, costoServicio, interno, did, sipServer, detalleEquipo, userStamp, timeStamp', 'safe', 'on' => 'search'),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations() {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array(
            'ciudad' => array(self::BELONGS_TO, 'Ciudades', 'ciudadId'),
            'cliente' => array(self::BELONGS_TO, 'Clientes', 'clienteId'),
            'ciclo' => array(self::BELONGS_TO, 'Ciclos', 'cicloId'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        return array(
            'id' => 'ID',
            'fechaInstalacion' => 'Fecha Instalacion',
            'domicilio' => 'Domicilio',
            'instaladores' => 'Instaladores',
            'ciudadId' => 'Ciudad',
            'barrioId' => 'Barrio',
            'clienteId' => 'Cliente',
            'cicloId' => 'Ciclo',
            'costoServicio' => 'Costo Servicio',
            'interno' => 'Interno',
            'did' => 'DID',
            'sipServer' => 'Sip Server',
            'detalleEquipo' => 'Detalle Equipo',
            'userStamp' => 'User Stamp',
            'timeStamp' => 'Time Stamp',
        );
    }

   

    //Calcula el costo de la tarifa de acuerdo al prefijo
    function obtenerTarifaLlamada($numero) {
        $connection = Yii::app()->db;

        $long_numero = strlen($numero);
        $ban = 0;
        $prefijo="";
        //DETECCION DEL PREFIJO

        if (substr($numero, 0, 4) == '0800' and $ban == 0) { // 0800 Gratuitos
            $prefijo = '0800';
            $ban = 1;
        }
        if (substr($numero, 0, 4) == '0810' and $ban == 0) { // 0810 Gratuitos
            $prefijo = '0810';
            $ban = 1;
        }

        if (substr($numero, 0, 2) == '00' and $ban == 0 and strlen($numero)>13) { //internacionales
            //echo "Internacional\n";
            // para este caso tenemos que hacer un laburito adicional para determinar el prefijo exacto
            $cant_reg = 2;
            $i = 2;

            while ($cant_reg > 1) {
                $prefijo = substr($numero, 2, $i);
                
                $sql = "SELECT prefijo,descripcion,precio_venta from tarifas where prefijo like '$prefijo%'";
                $command = $connection->createCommand($sql);
                
                $result = $command->queryAll($sql);
                $cant_reg = count($result);
                
                $i++;
            }
            //actualizamos el prefijo con el valor que me devolvio la tabla
            if ($cant_reg == 1) {
                $prefijo = $result[0]['prefijo'];
               
            }

             //vemos si el numero no es de USA ya que algoritmo falla en la deteccion de USA
            if (substr($numero, 2, 1) == 1) {
                $prefijo_ciudad = substr($numero, 3, 3);
            
                if ($prefijo_ciudad >= '201' and $prefijo_ciudad <= '989') {
            
                    $prefijo = '1';
                }
            }
            $ban = 1;
        }

        if ($long_numero == 7 && substr($numero, 0, 1) == '4' and $ban == 0) { // LOCALES FIJOS
            $prefijo = '4';
            $ban = 1;
        }
        if ($long_numero == 8 && substr($numero, 0, 2) == '94' and $ban == 0) { // LOCALES FIJOS
            $prefijo = '4';
            $ban = 1;
        }

        if ($long_numero == 9 and substr($numero, 0, 2) == '15' and $ban == 0) { // LOCALES CELULARES
            $prefijo = '15';
            $ban = 1;
        }
        if ($long_numero == 10 and substr($numero, 0, 3) == '915' and $ban == 0) { // LOCALES CELULARES
            $prefijo = '15';
            $ban = 1;
        }

        if ($long_numero == 11 and substr($numero, 0, 1) == '0' and $ban == 0) { // LDN FIJOS
            $prefijo = '0';
            $ban = 1;
        }
        if ($long_numero == 12 and substr($numero, 0, 2) == '90' and $ban == 0) { // LDN FIJOS
            $prefijo = '0';
            $ban = 1;
        }

        if ($long_numero == 13 and substr($numero, 0, 1) == '0' and $ban == 0) { // LDN Cel
            $prefijo = '015';
            $ban = 1;
        }
        if ($long_numero == 14 and substr($numero, 0, 2) == '90' and $ban == 0) { // LDN Cel
            $prefijo = '015';
            $ban = 1;
        }

        if ($long_numero <= 6 and $ban == 0) {
            $prefijo = '99999';
        }

        if ($prefijo != '') {
            $sql = "SELECT descripcion,precio_venta,prefijo from tarifas where prefijo='$prefijo'";
            $command = $connection->createCommand($sql);
            $tarifa = $command->queryRow();
        } else {
            $tarifa = array(
                'descripcion' => 'TARIFA GENERAL',
                'precio_venta' => '0.459',
                'prefijo' => '1111'
            );
        }
        return $tarifa;
    }

    function obtenerConsumo($fechaInicio, $fechaFin) {
        $connection = Yii::app()->db;
        $sql = "select calldate,dst,dstchannel,billsec as duracion_seg,ceil(billsec/60) as duracion_min
         from cdr
         where accountcode like '" . $this->interno . "' and (date(calldate) between '" . $fechaInicio . "' and
         '" . $fechaFin . "')
         AND disposition='ANSWERED' AND billsec > 10
         order by calldate";
        $command = $connection->createCommand($sql);
        $result = $command->queryAll($sql);
        $minutosTotales = 0;
        $cantidadLlamadas=0;
        $totalPagar=0; 
        $contador_minutos_libres = $this->minutosLibres;
        foreach ($result as $cdr) {
            $tarifa = $this->obtenerTarifaLlamada($cdr['dst']);
            if ($tarifa['prefijo'] == '4' or $tarifa['prefijo'] == '0') {
                $contador_minutos_libres = $contador_minutos_libres - $cdr['duracion_min'];
                if ($contador_minutos_libres > 0) {
                    $costoLlamada = 0.00;
                } else {
                    $costoLlamada = $tarifa['precio_venta'] * Yii::app()->params->cotizacionDolar * $cdr['duracion_min'];
                }
            } else {
                $costoLlamada = $tarifa['precio_venta'] * Yii::app()->params->cotizacionDolar * $cdr['duracion_min'];
            }

            $cantidadLlamadas++;
            $minutosTotales = $minutosTotales + $cdr['duracion_min'];

            $totalPagar = $totalPagar + $costoLlamada;
        }
         $resultado = array(
                'cantidadLlamadas' => $cantidadLlamadas,
                'totalPagar' => $totalPagar,
                'minutosTotales' => $minutosTotales,
            );
         return $resultado;
    }
    
    function detalleConsumo($fechaInicio, $fechaFin) {
        
        
        $connection = Yii::app()->db;
        
        $sql = "select calldate,dst,dstchannel,billsec as duracion_seg,ceil(billsec/60) as duracion_min
         from cdr
         where accountcode like '" . $this->interno . "' and (date(calldate) between '" . $fechaInicio . "' and
         '" . $fechaFin . "')
         AND disposition='ANSWERED' AND billsec > 10
         order by calldate";
        $command = $connection->createCommand($sql);
        return $command->queryAll($sql);
                
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
        $criteria->compare('fechaInstalacion', $this->fechaInstalacion, true);
        $criteria->compare('domicilio', $this->domicilio, true);
        $criteria->compare('ciudadId', $this->ciudadId);
        $criteria->compare('clienteId', $this->clienteId);
        $criteria->compare('cicloId', $this->cicloId);
        $criteria->compare('costoServicio', $this->costoServicio, true);
        $criteria->compare('interno', $this->interno, true);
        $criteria->compare('did', $this->did, true);
        $criteria->compare('sipServer', $this->sipServer, true);
        $criteria->compare('detalleEquipo', $this->detalleEquipo, true);
        $criteria->compare('userStamp', $this->userStamp, true);
        $criteria->compare('timeStamp', $this->timeStamp, true);

        return new CActiveDataProvider(get_class($this), array(
                    'criteria' => $criteria,
                ));
    }

}