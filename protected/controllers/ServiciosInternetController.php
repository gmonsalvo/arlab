<?php

class ServiciosInternetController extends Controller {

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
                'actions' => array('create', 'update', 'admin'),
                'users' => array('@'),
            ),
            array('allow', // allow admin user to perform 'admin' and 'delete' actions
                'actions' => array('delete', 'generarDebitos', 'prueba'),
                'users' => array('gmonsalvo', 'khaure'),
            ),
            array('allow', // allow admin user to perform 'admin' and 'delete' actions
                'actions' => array('admin', 'delete'),
                'users' => array('admin'),
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
    public function actionGenerarDebitos() {
        $connection = Yii::app()->db;
        $transaction = $connection->beginTransaction();
        try {


            $serviciosInternet = new ServiciosInternet();

            foreach ($serviciosInternet->findAll() as $si) {

                if ($si->cliente->estado == Clientes::ESTADO_ACTIVO) {
                    //armamos el periodo
                    $periodoInicio = $_GET['periodoInicio'];
                    $periodoFin = $_GET['periodoFin'];

                    $mesInicio = intval(substr($periodoInicio, 4, 2));
                    $mesFin = intval(substr($periodoFin, 4, 2));
                    $anio = substr($periodoInicio, 0, 4);
                    $i = $mesInicio;

                    //echo "<b>Cliente:</b>" . $si->cliente->razonSocial . "<br>";
                    //echo "Servicio: " . $si->domicilio . "<br>";
                    while ($i <= $mesFin) {
                        //generamos las notas de venta para los periodos desde
                        //la fecha de alta hasta el fin del periodo
                        //echo "<b>Periodo:</b>" . $anio . str_pad($i, '2', "0", STR_PAD_LEFT) . "<br>";
                        
                        
                        $notaVenta = new NotaVenta();
                        //antes de generar verificamos que no este generada ya la nota de venta para este
                        //servicio y para este periodo 
                        $control="periodo='".$anio . str_pad($i, '2', "0", STR_PAD_LEFT)."' AND servicioId='".$si->id."'";
                        if (!($notaVenta->exists($control))){
                            $notaVenta->fecha = date("d/m/Y");
                            $notaVenta->fechaVencimiento = "10/" . str_pad($i, '2', "0", STR_PAD_LEFT) . "/" . $anio;
                            $notaVenta->clienteId = $si->clienteId;
                            $notaVenta->servicioId = $si->id;
                            $notaVenta->periodo = $anio . str_pad($i, '2', "0", STR_PAD_LEFT);
                            //tenemos en cuenta que si es el mes del alta tenemos que 
                            //generar un proporional
                            $notaVenta->detalle = "Abono " . $si->plan->descripcion;
                            $notaVenta->monto = $si->costoServicio * 1.21;
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
                                    Yii::app()->end();
                                }
                            } else {
    //redireccionamos a la pagina del cliente
                                echo "Error al guardar la cuenta corriente";
                                $transaction->rollBack();
                                Yii::app()->end();
                            }
                         }   
                        $i++;
                    }
                } // fin del if del control de cliente activo
            }
            $transaction->commit();
            echo "Fin.";
        } catch (Exception $e) {
            echo $e;
        }
    }

    public function actionCreate() {
        $model = new ServiciosInternet;

// Uncomment the following line if AJAX validation is needed
// $this->performAjaxValidation($model);
        $transaction = $model->dbConnection->beginTransaction();
        try {

            if (isset($_POST['ServiciosInternet'])) {

                $model->attributes = $_POST['ServiciosInternet'];
                if ($model->save()) {
                    if (Yii::app()->params->generaDebitos) {

                        $timestamp = strtotime($model->fecha_instalacion);
                        $cantdelmes = date("t", $timestamp);
                        $mes = date('m', $timestamp);
                        $anio = date('Y', $timestamp);
                        $dia = date('d', $timestamp);
                        $i = (int) $mes;

                        while ($i <= 12) {
                            //generamos las notas de venta para los periodos desde
                            //la fecha de alta hasta el fin del periodo
                            $notaVenta = new NotaVenta();
                            $notaVenta->fecha = date("d/m/Y");
                            $notaVenta->fechaVencimiento = "10/" . str_pad($i, '2', "0", STR_PAD_LEFT) . "/" . $anio;
                            $notaVenta->clienteId = $model->clienteId;
                            $notaVenta->servicioId = $model->id;
                            $notaVenta->periodo = $anio . str_pad($i, '2', "0", STR_PAD_LEFT);
                            //tenemos en cuenta que si es el mes del alta tenemos que 
                            //generar un proporional
                            //echo "10/".$mes."/".$anio."<br>";
                            //echo date("d/m/Y");
                            //Yii::app()->end();
                            if ($i == $mes) {
                                $notaVenta->detalle = "Abono Proporcional " . $model->plan->descripcion;
                                $notaVenta->monto = ($model->costoServicio / $cantdelmes) * (($cantdelmes - $dia) + 1) * 1.21;;
                            } else {
                                $notaVenta->detalle = "Abono " . $model->plan->descripcion;
                                $notaVenta->monto = $model->costoServicio * 1.21;
                            }
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
                                }
                            }
                            $i++;
                        }
                    }
                    //descontamos el stock correspondiente
                    if (Yii::app()->params->descontarStock) {
                        $stock = new MovimientosStock;
                        //Movimiento de Para el deposito asociado al instalador
                        $stock->fecha = $model->fecha_instalacion;
                        $stock->depositoId = $model->instaladores->depositoId;
                        $stock->equipoId = $model->equipoId;
                        $stock->tipoMov = 1;
                        $stock->cantidad = 1;
                        $stock->observaciones = "Instalacion " . $model->cliente->razonSocial;
                        $stock->userStamp = Yii::app()->user->model->username;
                        $stock->timeStamp = Date("Y-m-d h:m:s");
                        $stock->save();
                    }

                    $transaction->commit();
                    $this->redirect(array('/clientes/view', 'id' => $model->clienteId));
                } else {
                    echo "Error al guardar el servicio";
                    $transaction->rollBack();
                }
            }
            $this->render('create', array(
                'model' => $model,
            ));
        } catch (Exception $e) {
            print_r($e);
//$transaction->rollBack();
        }
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

        if (isset($_POST['ServiciosInternet'])) {
            $model->attributes = $_POST['ServiciosInternet'];
            $model->lastUserUpdate = Yii::app()->user->model->username;

            if ($model->save())
                $this->redirect(array('/clientes/view', 'id' => $model->clienteId));
        }

        $this->render('update', array(
            'model' => $model,
        ));
    }

    public function actionPrueba($id) {
        $si = $this->loadModel($id);
        $timestamp = strtotime($si->fecha_instalacion);
        $cantdelmes = date("t", $timestamp);
        $mes = date('m', $timestamp);
        $anio = date('Y', $timestamp);
        $dia = date('d', $timestamp);
        $i=(int) $mes; 

        echo "Dia:" . $dia . "<br>";
        echo "Mes:" . $mes . "<br>";
        echo "I:" . $i . "<br>";
        echo "Anio:" . $anio . "<br>";
        echo "Dias del Mes :" . $cantdelmes . "<br>";
        echo "Costo del Servicio:" . $si->costoServicio . "<br>";
        echo ($si->costoServicio / $cantdelmes) * (($cantdelmes - $dia) + 1) * 1.21;
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
        $dataProvider = new CActiveDataProvider('ServiciosInternet');
        $this->render('index', array(
            'dataProvider' => $dataProvider,
        ));
    }

    /**
     * Manages all models.
     */
    public function actionAdmin() {
        $model = new ServiciosInternet('search');
        $model->unsetAttributes();  // clear any default values
        if (isset($_GET['ServiciosInternet']))
            $model->attributes = $_GET['ServiciosInternet'];

        $this->render('admin', array(
            'model' => $model,
        ));
    }

    /**
     * Returns the data model based on the primary key given in the GET variable.
     * If the data model is not found, an HTTP exception will be raised.
     * @param integer the ID of the model to be loaded
     */
    public function loadModel($id) {
        $model = ServiciosInternet::model()->findByPk((int) $id);
        if ($model === null)
            throw new CHttpException(404, 'The requested page does not exist.');
        return $model;
    }

    /**
     * Performs the AJAX validation.
     * @param CModel the model to be validated
     */
    protected function performAjaxValidation($model) {
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'servicios-internet-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }

}
