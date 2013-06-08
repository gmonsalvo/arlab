<?php

class NotaVentaController extends Controller {

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
                'actions' => array('create', 'update', 'agregarObs', 'getNotaVenta', 'reporteMorosos', 'actualizaEstado'),
                'users' => array('@'),
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

    public function actionAgregarObs($id) {
        $model = $this->loadModel($id);

        // Uncomment the following line if AJAX validation is needed
        // $this->performAjaxValidation($model);

        if (isset($_POST['NotaVenta'])) {
            $model->observaciones = $_POST['NotaVenta']['observaciones'];

            if ($model->save())
            //print_r($_POST['NotaVenta']);
                $this->redirect(array('ctaCteClientes/admin?clienteId=' . $model->clienteId));
        }

        $this->render('agregarObs', array(
            'model' => $model,
        ));
    }

    /**
     * Creates a new model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     */
    public function actionCreate() {
        $model = new NotaVenta;
        $transaction = $model->dbConnection->beginTransaction();
        try {
            // Uncomment the following line if AJAX validation is needed
            // $this->performAjaxValidation($model);

            if (isset($_POST['NotaVenta'])) {
                $model->attributes = $_POST['NotaVenta'];
                //Agregamos el iva a la nota de venta
                $model->monto = $model->monto * 1.21;
                $model->userStamp = Yii::app()->user->model->username;
                if ($model->save()) {
                    //cargamos el debito en la cuenta corriente del cliente
                    $ctacte = new CtaCteClientes();
                    $ctacte->tipoMov = 0;
                    $ctacte->notaVentaId = $model->id;
                    $ctacte->fecha = date("Y-m-d");
                    $ctacte->conceptoId = 13;
                    $ctacte->monto = $model->monto;
                    $ctacte->userStamp = Yii::app()->user->model->username;
                    $ctacte->timeStamp = Date("Y-m-d h:m:s");
                    if ($ctacte->save()) {
                        //redireccionamos a la pagina del cliente
                        Yii::app()->user->setFlash('success', 'Nota de Venta Procesada Con Exito');
                        $transaction->commit();
                        $this->redirect(array('clientes/view', 'id' => $model->clienteId));
                    } else {
                        //redireccionamos a la pagina del cliente
                        Yii::app()->user->setFlash('errpr', 'No se Guardo en Cuenta Corriente');
                        $transaction->rollBack();
                        $this->redirect(array('clientes/view', 'id' => $model->clienteId));
                    }
                }
            }

            $this->render('create', array(
                'model' => $model,
            ));
        } catch (Exception $e) {
            $transaction->rollBack();
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

        if (isset($_POST['NotaVenta'])) {
            $model->attributes = $_POST['NotaVenta'];
            if ($model->save())
                $this->redirect(array('view', 'id' => $model->id));
        }

        $this->render('update', array(
            'model' => $model,
        ));
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
        $dataProvider = new CActiveDataProvider('NotaVenta');
        $this->render('index', array(
            'dataProvider' => $dataProvider,
        ));
    }

    /**
     * Manages all models.
     */
    public function actionAdmin() {
        $model = new NotaVenta('search');
        $model->unsetAttributes();  // clear any default values
        if (isset($_GET['NotaVenta']))
            $model->attributes = $_GET['NotaVenta'];

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
        $model = NotaVenta::model()->findByPk((int) $id);
        if ($model === null)
            throw new CHttpException(404, 'The requested page does not exist.');
        return $model;
    }

    /**
     * Performs the AJAX validation.
     * @param CModel the model to be validated
     */
    protected function performAjaxValidation($model) {
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'nota-venta-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }

    public function actionActualizaEstado() {
        $i = 0;
        ini_set('memory_limit', '-1');
        $notaVentas=NotaVenta::model()->findAll("periodo>=201301");

        echo "Cantidad:".count($notaVentas);
       
        foreach ($notaVentas as $nv) {
            $saldo = $nv->getSaldo();
            if ($nv->monto != 0) {
                if ($saldo <= 0) {
                    // esta pagado entonces revisamos el estado deberia ser 1
                    if ($nv->estado != 1) {
                        echo $i . "-Saldo de una nota de venta sin saldo con el estado erroneo, <b>nvID:" . $nv->id . "</b><br>";
                        $nv->estado=1;
                        if ($nv->save()){
                            echo "<b>Se actualizo la nota de venta con exito</b><br>";
                        }else{
                             echo "<b>Fallo la actualizacion</b><br>";
                        }
                        $i++;
                    }
                } else { //esta con saldo deberia ser 0 
                    if ($nv->estado != 0) {
                        echo $i . "-Saldo de una nota de venta con saldo con el estado erroneo, <b>nvID:" . $nv->id . "</b><br>";
                          $nv->estado=0;
                        if ($nv->save()){
                           echo "<b>Se actualizo la nota de venta con exito</b><br>";
                        }else{
                             echo "<b>Fallo la actualizacion</b><br>";
                        }
                        $i++;
                    }
                }
            }
        }
        
        echo "Fin.<br>";
    }

    public function actionGetNotaVenta() {
        if (isset($_POST)) {
            $criteria = new CDbCriteria();
            $criteria->addInCondition("id", $_POST["notaVentaId"]);
            $notaVentas = NotaVenta::model()->findAll($criteria);
            $montoTotal = 0;
            foreach ($notaVentas as $notaVenta) {
                $montoTotal+=$notaVenta->getSaldoSinIva();
            }
            echo CJSON::encode(
                    array(
                        'success' => true,
                        'montoTotal' => $montoTotal,
                    )
            );
        }
    }

    public function actionReporteMorosos() {
        $model = new NotaVenta();
        $this->render('reporteMorosos', array(
            'model' => $model,
        ));
    }

}
