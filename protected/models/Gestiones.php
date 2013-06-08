<?php

/**
 * This is the model class for table "gestiones".
 *
 * The followings are the available columns in table 'gestiones':
 * @property integer $id
 * @property integer $temaId
 * @property string $detalle
 * @property integer $clienteId
 * @property string $fecha
 * @property integer $estado
 * @property string $usuarioResponsable
 * @property integer $gestionPadreId
 * @property string $userStamp
 * @property string $timeStamp
 *
 * The followings are the available model relations:
 * @property Soportes $soporte
 */
class Gestiones extends CActiveRecord {

    /**
     * Returns the static model of the specified AR class.
     * @return Gestiones the static model class
     */
    public $tipoGestionId;
    public $diasGestion;
    public $direccionCliente;
    public $ciudadCliente;
        
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return 'gestiones';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('temaId, clienteId, fecha,detalle,usuarioResponsable', 'required'),
            array('temaId, clienteId, estado, gestionPadreId', 'numerical', 'integerOnly' => true),
            array('usuarioResponsable', 'length', 'max' => 50),
            array('userStamp,timeStamp', 'safe'),
            // The following rule is used by search().
            // Please remove those attributes that should not be searched.
            array('id, temaId, detalle, clienteId, fecha, estado, usuarioResponsable, gestionPadreId, userStamp, timeStamp,ciudadCliente,direccionCliente', 'safe', 'on' => 'search'),
        );
    }

    /**
     * @return array relational rules.
     */
    
    public function relations() {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array(
            'tema' => array(self::BELONGS_TO, 'TemasGestion', 'temaId'),
            'cliente' => array(self::BELONGS_TO, 'Clientes', 'clienteId'),
            'usuario' => array(self::BELONGS_TO, 'User', 'usuarioResponsable'),
            'gestionesHijas' => array(self::BELONGS_TO, 'Gestiones', 'gestionPadreId'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        return array(
            'id' => 'ID',
            'temaId' => 'Tema',
            'detalle' => 'Detalle',
            'clienteId' => 'Cliente',
            'fecha' => 'Fecha',
            'estado' => 'Estado',
            'usuarioResponsable' => 'Usuario Responsable',
            'gestionPadreId' => 'Gestion Padre',
            'userStamp' => 'Creado por',
            'timeStamp' => 'Fecha/Hora Creacion',
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
        
    public function searchServiciosTecnicos() {
        // Warning: Please modify the following code to remove attributes that
        // should not be searched.

        $criteria = new CDbCriteria;
        
        $criteria->with = array( 'tema','cliente' );
        
        
        $criteria->compare('id', $this->id);
        $criteria->compare('temaId', $this->temaId);
        $criteria->compare('detalle', $this->detalle, true);
        $criteria->compare('clienteId', $this->clienteId);
        $criteria->compare('fecha', $this->fecha, true);
        $criteria->compare('estado', $this->estado);
        $criteria->compare('usuarioResponsable', $this->usuarioResponsable, true);
        $criteria->compare('userStamp', $this->userStamp, true);
        $criteria->compare('timeStamp', $this->timeStamp, true);
        $criteria->compare('cliente.ciudadId', $this->ciudadCliente, true);
        $criteria->compare('cliente.direccion', $this->direccionCliente, true);
        
        $criteria->addCondition('tema.tipoGestionId=3');
        $criteria->addCondition('gestionPadreId is NULL');
        $criteria->addCondition('t.estado=0');
        $criteria->order="fecha ASC";

        return new CActiveDataProvider($this, array(
                    'criteria' => $criteria,
                ));
    }
    
    
     public function searchCobranzas() {
        // Warning: Please modify the following code to remove attributes that
        // should not be searched.

        $criteria = new CDbCriteria;
        
        $criteria->with = array( 'tema','cliente' );
        
        
        $criteria->compare('id', $this->id);
        $criteria->compare('temaId', $this->temaId);
        $criteria->compare('detalle', $this->detalle, true);
        $criteria->compare('clienteId', $this->clienteId);
        $criteria->compare('fecha', $this->fecha, true);
        $criteria->compare('estado', $this->estado);
        $criteria->compare('usuarioResponsable', $this->usuarioResponsable, true);
        $criteria->compare('userStamp', $this->userStamp, true);
        $criteria->compare('timeStamp', $this->timeStamp, true);
        $criteria->compare('cliente.ciudad', $this->ciudadCliente, true);
        $criteria->compare('cliente.direccion', $this->direccionCliente, true);
        
        $criteria->addCondition('tema.tipoGestionId=1');
        $criteria->addCondition('gestionPadreId is NULL');
        $criteria->addCondition('t.estado=0');
        $criteria->order="fecha ASC";

        return new CActiveDataProvider($this, array(
                    'criteria' => $criteria,
                ));
    }

    public function gestionesHijas($gestionId, $limit = 5) {

        $where = " gestionPadreId='" . $gestionId . "' ";

        $dataProvider = new CActiveDataProvider('Gestiones',
                        array(
                            'criteria' => array(
                                'condition' => $where,
                                'order' => 'fecha DESC',
                            ),
                            'pagination' => array(
                                'pageSize' => $limit,
                            ),
                ));

        return $dataProvider;
    }
    
 public function soloPadres($clienteId,$limit=10) {

        $where = "gestionPadreId is NULL AND clienteId='".$clienteId."'";

        $dataProvider = new CActiveDataProvider('Gestiones',
                        array(
                            'criteria' => array(
                                'condition' => $where,
                                'order' => 'fecha DESC',
                            ),
                            'pagination' => array(
                                'pageSize' => $limit,
                            ),
                ));

        return $dataProvider;
    }
    
    public function getGestionActiva($clienteId) {
        // Warning: Please modify the following code to remove attributes that
        // should not be searched.

        $criteria = new CDbCriteria;
        
        $criteria->with = array( 'tema');
              
        $criteria->addCondition('tema.tipoGestionId=1');
        $criteria->addCondition('gestionPadreId is NULL');
        $criteria->addCondition('t.estado=0');
        $criteria->addCondition('t.clienteId=:clienteId');
        $criteria->params=array(':clienteId'=>$clienteId);
      
        $gestion = Gestiones::model()->find($criteria);
        
         
        if (isset($gestion)){
            return $gestion->id;
         }else{
            return null;
        }         
      
    }
    
}