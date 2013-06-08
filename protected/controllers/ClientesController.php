<?php

class ClientesController extends Controller {

    /**
     * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
     * using two-column layout. See 'protected/views/layouts/column2.php'.
     */
    public $layout = '//layouts/column2';

    /**
     * @return array action filters
     */
    public function filters() {
        return array(
            'accessControl', // perform access control for CRUD operations
        );
    }

    /**
     * Specifies the access control rules.
     * This method is used by the 'accessControl' filter.
     * @return array access control rules
     */
    public function accessRules() {
        return array(
            array('allow', // allow all users to perform 'index' and 'view' actions
                'actions' => array('index', 'view'),
                'users' => array('*'),
            ),
            array('allow', // allow authenticated user to perform 'create' and 'update' actions
                'actions' => array('create', 'update', 'admin', 'buscarRazonSocial','viewReporteMorosos','getReporteMorosos','pagosElectronicos','finalizarPagoElectronico','viewSuspendidos'),
                'users' => array('@'),
             ),    
            array('allow', // allow authenticated user to perform 'create' and 'update' actions
                'actions' => array('create', 'update', 'admin', 'buscarRazonSocial','delete', 'generaSaldoInicial', 'suspender', 'baja','activar'),
                'users' => array('khaure','gmonsalvo'),
           
            ),
            array('deny', // deny all users
                'users' => array('*'),
            ),
        );
    }

    /**
     * Displays a particular model.
     * @param integer $id the ID of the model to be displayed
     */
    public function actionView($id) {
        $this->render('view', array(
            'model' => $this->loadModel($id),
        ));
    }

    /**
     * Creates a new model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     */
    public function actionCreate() {
        $model = new Clientes;

        // Uncomment the following line if AJAX validation is needed
        // $this->performAjaxValidation($model);

        if (isset($_POST['Clientes'])) {
            $model->attributes = $_POST['Clientes'];
            $model->createStamp = Date("Y-m-d h:m:s");
            $model->userStamp = Yii::app()->user->model->username;
            if ($model->save())
                $this->redirect(array('view', 'id' => $model->id));
        }

        $this->render('create', array(
            'model' => $model,
        ));
    }

    /**
     * Updates a particular model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id the ID of the model to be updated
     */
    public function actionUpdate($id) {
        $model = $this->loadModel($id);

        // Uncomment the following line if AJAX validation is needed
        // $this->performAjaxValidation($model);

        if (isset($_POST['Clientes'])) {
            $model->attributes = $_POST['Clientes'];
            $model->lastUpdateStamp = Date("Y-m-d h:m:s");
            $model->lastUserUpdate = Yii::app()->user->model->username;
            if ($model->save())
                $this->redirect(array('view', 'id' => $model->id));
        }

        $this->render('update', array(
            'model' => $model,
        ));
    }

    public function actionActivar($id) {
        $model = $this->loadModel($id);

        $model->estado = Clientes::ESTADO_ACTIVO;
        $model->fechaBaja=null;
        $model->fechaSuspension=null;
        if ($model->save()){
            //generamos el registro en cambiosPlan para que se realice la operaicon
            $cambio=new CambioPlan();
            $cambio->servicioInternetId=0;
            $cambio->fecha=date('Y-m-d');
            $cambio->accion=CambioPlan::ACCION_ACTIVACION;
            $cambio->observaciones="Reactivar los servicios del cliente:".$model->razonSocial;
            $cambio->planId=$model->serviciosInternets[0]->planId;
            $cambio->costoServicio=$model->serviciosInternets[0]->costoServicio;
            $cambio->estado=0;
            $cambio->periodoInicio='000000';
            $cambio->timeStamp = Date("Y-m-d h:m:s");
            $cambio->userStamp = Yii::app()->user->model->username;
            if ($model->save()){
                $this->redirect(array('view', 'id' => $model->id));
            }else{
                print_r($model->getErrors());
                echo "error al guardar el cambio de plan";
                
            }  
        }else{
            print_r($model->getErrors());
            echo "error al guardar";
        }  
    }

    public function actionBaja($id) {
        $model = $this->loadModel($id);

        $model->estado = Clientes::ESTADO_BAJA;
        $model->fechaBaja=date('Y-m-d');
        if ($model->save()){
            $cambio=new CambioPlan();
            $cambio->servicioInternetId=0;
            $cambio->fecha=date('Y-m-d');
            $cambio->accion=CambioPlan::ACCION_BAJA;
            $cambio->observaciones="Reactivar los servicios del cliente:".$model->razonSocial;
            $cambio->planId=$model->serviciosInternets[0]->planId;
            $cambio->costoServicio=$model->serviciosInternets[0]->costoServicio;
            $cambio->estado=0;
            $cambio->periodoInicio='000000';
            $cambio->timeStamp = Date("Y-m-d h:m:s");
            $cambio->userStamp = Yii::app()->user->model->username;
            if ($model->save()){
                $this->redirect(array('view', 'id' => $model->id));
            }else{
                print_r($model->getErrors());
                echo "error al guardar el cambio de plan";
            }  
            
        }else{
            print_r($model->getErrors());
            echo "error al guardar";
        }  
    }

    public function actionSuspender($id) {
        $model = $this->loadModel($id);

        $model->estado = Clientes::ESTADO_SUSPENDIDO;
        $model->fechaSuspension=date('Y-m-d');
        //realizamos la suspension de los servicios del cliente que se esta suspendiendo
        $servicios=$model->getServiciosInternet();
        foreach ($servicios as $servicio) {
                $API = new RouterOS();
                $API->debug = false;
                if ($API->connect($servicio->servidor->ip_wan,$servicio->servidor->usuario,$servicio->servidor->password)) {
                      $API->write('/ip/firewall/address-list/add',false);
                      $API->write('=address='.$ip,false);
                      $API->write('=list=payment_reminder',true);
                      $READ = $API->read();
                      print_r($READ);
                      $API->disconnect();  
                } // if connect 

        } //fin del for

        if ($model->save())
            $cambio=new CambioPlan();
            $cambio->servicioInternetId=0;
            $cambio->fecha=date('Y-m-d');
            $cambio->accion=CambioPlan::ACCION_SUSPENSION;
            $cambio->observaciones="Reactivar los servicios del cliente:".$model->razonSocial;
            $cambio->planId=$model->serviciosInternets[0]->planId;
            $cambio->costoServicio=$model->serviciosInternets[0]->costoServicio;
            $cambio->estado=0;
            $cambio->periodoInicio='000000';
            $cambio->timeStamp = Date("Y-m-d h:m:s");
            $cambio->userStamp = Yii::app()->user->model->username;
            if ($model->save()){
                $this->redirect(array('view', 'id' => $model->id));
            }else{
                print_r($model->getErrors());
                echo "error al realizar la suspension";

            }  


    }

    public function actionGeneraSaldoInicial() {

        if (isset($_GET['archivo'])) {
            echo "Generando Saldos Iniciales Para:" . $_GET['archivo'] . "<br>";
            $connection = Yii::app()->db;
            $command = $connection->createCommand("SELECT id,saldo FROM " . $_GET['archivo']);
            $saldos = $command->query();
            $transaction = $connection->beginTransaction();
            foreach ($saldos as $saldo) {
                //aca generamos la nota de debito y el movimiento de debito en la cuenta
                //corriente
                echo $saldo['id'] . "<br>";
                if ($saldo['saldo']!="0"){
                $notaVenta = new NotaVenta();
                $notaVenta->fecha = date("d/m/Y");
                $notaVenta->fechaVencimiento = "10/07/2012";
                $notaVenta->clienteId = $saldo['id'];
                $notaVenta->servicioId = 0;
                $notaVenta->periodo = "072012";
                $notaVenta->detalle = "Saldo Anterior";
                $notaVenta->monto = $saldo['saldo'];
                $notaVenta->userStamp = Yii::app()->user->model->username;
                $notaVenta->timeStamp = Date("Y-m-d h:m:s");

                if ($notaVenta->save()) {
                    //cargamos el debito en la cuenta corriente del cliente
                    $ctacte = new CtaCteClientes();
                    $ctacte->tipoMov = 0;
                    $ctacte->notaVentaId = $notaVenta->id;
                    $ctacte->fecha = date("Y-m-d");
                    $ctacte->conceptoId = 13;
                    $ctacte->monto = $notaVenta->monto;
                    $ctacte->userStamp = Yii::app()->user->model->username;
                    $ctacte->timeStamp = Date("Y-m-d h:m:s");
                    if (!($ctacte->save())) {
                        //redireccionamos a la pagina del cliente
                        echo "Error al guardar la cuenta corriente";
                        $transaction->rollBack();
                        yii::app()->end();
                    }
                } else {
                    //redireccionamos a la pagina del cliente
                    echo "Error al guardar la nota de Venta";
                    $transaction->rollBack();
                    yii::app()->end();
                }
                }//fin del if del control del monto 0
            } //fin del for
            $transaction->commit();
            
        }
    }

    /**
     * Deletes a particular model.
     * If deletion is successful, the browser will be redirected to the 'admin' page.
     * @param integer $id the ID of the model to be deleted
     */
    public function actionDelete($id) {
        if (Yii::app()->request->isPostRequest) {
            // we only allow deletion via POST request
            $this->loadModel($id)->delete();

            // if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
            if (!isset($_GET['ajax']))
                $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
        }
        else
            throw new CHttpException(400, 'Invalid request. Please do not repeat this request again.');
    }

    /**
     * Lists all models.
     */
    public function actionIndex() {
        $dataProvider = new CActiveDataProvider('Clientes');
        $this->render('index', array(
            'dataProvider' => $dataProvider,
        ));
    }

    /**
     * Manages all models.
     */
    public function actionAdmin() {
        $model = new Clientes('search');
        $model->unsetAttributes();  // clear any default values
        if (isset($_GET['Clientes']))
            $model->attributes = $_GET['Clientes'];

        $this->render('admin', array(
            'model' => $model,
        ));
    }

      /**
     * Manages all models.
     */
    public function actionViewSuspendidos() {
        $model = new Clientes('search');
        $model->unsetAttributes();  // clear any default values
        if (isset($_GET['Clientes']))
            $model->attributes = $_GET['Clientes'];

        $this->render('clientesSuspendidos', array(
            'model' => $model,
        ));
    }


    /**
     * Returns the data model based on the primary key given in the GET variable.
     * If the data model is not found, an HTTP exception will be raised.
     * @param integer the ID of the model to be loaded
     */
    public function loadModel($id) {
        $model = Clientes::model()->findByPk((int) $id);
        if ($model === null)
            throw new CHttpException(404, 'The requested page does not exist.');
        return $model;
    }

    /**
     * Performs the AJAX validation.
     * @param CModel the model to be validated
     */
    protected function performAjaxValidation($model) {
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'clientes-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }

    // data provider para el campo de autocompletado buscnado por razonSocial y tomando el clienteId 
    public function actionBuscarRazonSocial() {
        $q = $_GET['term'];
        if (isset($q)) {
            $criteria = new CDbCriteria;
            //si agregue a la url los tipos busca filtra en la busqueda por esos
            if (isset($_GET['tipo']))
                $criteria->compare('tipoCliente', $_GET['tipo'], "OR");

            $criteria->compare('razonSocial', $q, true);
            //$criteria->condition = ' UCASE(razonSocial) like :q'; 
            $criteria->order = 'razonSocial'; // correct order-by field
            $criteria->limit = 50;
            //$criteria->params = array(':q' => '%' . strtoupper(trim($q)) . '%'); 
            $clientes = Clientes::model()->findAll($criteria);

            if (!empty($clientes)) {
                $out = array();
                foreach ($clientes as $c) {
                    $out[] = array(
                        'label' => $c->razonSocial,
                        'value' => $c->razonSocial,
                        'id' => $c->id, // 
                    );
                }

                echo CJSON::encode($out);
                Yii::app()->end();
            } else {
                echo "La consulta no devolvio resultados";
            }
        }
    }
    
    public function actionViewReporteMorosos(){
        $model=new Clientes();
        $this->render("reporteMorosos", array("model"=>$model,'notaVenta'=>new NotaVenta()));
    }

    /*PAGOS ELECTRONICOS*/

    public function actionPagosElectronicos(){
        $model=new PagosElectronicos();
        $this->render("pagosElectronicos",array("model"=>$model));
    }

      public function actionFinalizarPagoElectronico($id) {
        $model = PagosElectronicos::model()->findByPk($id);

        // Uncomment the following line if AJAX validation is needed
        // $this->performAjaxValidation($model);
        //$model->attributes=$_POST['CambioPlan'];
        $model->estado = 1;
        $model->fechaAcreditacion=date('Y/m/d');
        if ($model->save())
        $this->redirect(array('pagosElectronicos'));
    }
    
    public function actionGetReporteMorosos(){
        if(isset($_GET["fechaVencimiento"])){
            ereg( "([0-9]{1,2})/([0-9]{1,2})/([0-9]{2,4})", $_GET["fechaVencimiento"], $fechaVencimiento);
            $fechaVencimiento=$fechaVencimiento[3]."-".$fechaVencimiento[2]."-".$fechaVencimiento[1]; 
            $periodosAdeudados=$_GET["periodosAdeudados"];
        } else {
            $fechaVencimiento = date("Y-m-d");
            $periodosAdeudados=5;
        }
        $model=new Clientes();
        $this->renderPartial("gridReporteMorosos",array("arrayDataProvider"=>$model->getReporteMorosos($fechaVencimiento,$periodosAdeudados)));

    }

}
