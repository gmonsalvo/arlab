<?php

class ColocacionesController extends Controller {

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
                'actions' => array('create', 'update', 'delete', 'asignarColocaciones', 'recolocacion', 'editarColocacion', 'recolocar','realizarRecolocacion'),
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

    /**
     * Creates a new model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     */
    public function actionCreate() {
        $model = new Colocaciones;
        // Uncomment the following line if AJAX validation is needed
        // $this->performAjaxValidation($model);

        if (isset($_POST['Colocaciones'])) {
            $model->attributes = $_POST['Colocaciones'];
            $model->fecha = Utilities::MysqlDateFormat($model->fecha);
            $model->estado = Colocaciones::ESTADO_ACTIVA;

            $connection = Yii::app()->db;
            $command = Yii::app()->db->createCommand();
            $transaction = $connection->beginTransaction();
            try {
                if ($model->save()) {
                    $colocacionId = $model->id;
                    $cheques = Cheques::model()->findByPk($model->chequeId);
                    $cheques->estado = Cheques::TYPE_EN_CARTERA_COLOCADO;
                    $cheques->save();
                    $sql = "INSERT INTO detalleColocaciones (colocacionId, clienteId, monto, tasa) 
						VALUES(:colocacionId, :clienteId, :monto, :tasa)";
                    $command = $connection->createCommand($sql);
                    $listaDetalleColocaciones = explode(',', $_POST['detallesColocaciones']);
                    for ($i = 0; $i < count($listaDetalleColocaciones); $i = $i + 5) {
                        $command->bindValue(":colocacionId", $colocacionId, PDO::PARAM_STR);
                        $command->bindValue(":clienteId", $listaDetalleColocaciones[$i], PDO::PARAM_STR);
                        $command->bindValue(":monto", Utilities::Unformat($listaDetalleColocaciones[$i + 2]), PDO::PARAM_STR);
                        $command->bindValue(":tasa", $listaDetalleColocaciones[$i + 3], PDO::PARAM_STR);
                        $command->execute();
                    }
                    $sql = "INSERT INTO ctacteClientes 
                                            (tipoMov, conceptoId, clienteId, productoId, descripcion, monto, fecha, operacionRelacionada, userStamp, timeStamp, sucursalId) 
                                            VALUES (:tipoMov, :conceptoId, :clienteId, :productoId, :descripcion, :monto, :fecha, :operacionRelacionada, :userStamp, :timeStamp, :sucursalId)";


                    $command = $connection->createCommand($sql);
                    $tipoMov = 1; //debito
                    $conceptoId = 9; //
                    $productoId = 1; //compra de cheques
                    $descripcion = "Colocacion";
                    $fecha = Date("Y-m-d");
                    $operacionRelacionada = "Colocacion";
                    $userStamp = Yii::app()->user->model->username;
                    $timeStamp = Date("Y-m-d h:m:s");
                    $sucursalId = Yii::app()->user->model->sucursalId;

                    for ($i = 0; $i < count($listaDetalleColocaciones); $i = $i + 5) {
                        $command->bindValue(":tipoMov", $tipoMov, PDO::PARAM_STR);
                        $command->bindValue(":conceptoId", $conceptoId, PDO::PARAM_STR);
                        $command->bindValue(":clienteId", $listaDetalleColocaciones[$i], PDO::PARAM_STR);
                        $command->bindValue(":productoId", $productoId, PDO::PARAM_STR);
                        $command->bindValue(":descripcion", $descripcion, PDO::PARAM_STR);

                        $valorActual = $model->calculoValorActual(Utilities::Unformat($listaDetalleColocaciones[$i + 2]), Utilities::ViewDateFormat($model->cheque->fechaPago), $listaDetalleColocaciones[$i + 3], $model->cheque->clearing);

                        $command->bindValue(":monto", $valorActual, PDO::PARAM_STR);
                        $command->bindValue(":fecha", $fecha, PDO::PARAM_STR);
                        $command->bindValue(":operacionRelacionada", $operacionRelacionada, PDO::PARAM_STR);
                        $command->bindValue(":userStamp", $userStamp, PDO::PARAM_STR);
                        $command->bindValue(":timeStamp", $timeStamp, PDO::PARAM_STR);
                        $command->bindValue(":sucursalId", $sucursalId, PDO::PARAM_STR);
                        $command->execute();
                    }

                    $transaction->commit();
                    $this->redirect(array('view', 'id' => $model->id));
                }
            } catch (Exception $e) { // an exception is raised if a query fails
                $transaction->rollBack();
            }
        }

        $this->render('create', array(
            'model' => $model, 'cheques' => new Cheques, 'clientes' => new Clientes)
        );
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

        if (isset($_POST['Colocaciones'])) {
            $model->attributes = $_POST['Colocaciones'];
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
        $dataProvider = new CActiveDataProvider('Colocaciones');
        $this->render('index', array(
            'dataProvider' => $dataProvider,
        ));
    }

    /**
     * Manages all models.
     */
    public function actionAdmin() {
        $model = new Colocaciones('search');
        $model->unsetAttributes();  // clear any default values
        if (isset($_GET['Colocaciones']))
            $model->attributes = $_GET['Colocaciones'];

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
        $model = Colocaciones::model()->findByPk($id);
        if ($model === null)
            throw new CHttpException(404, 'The requested page does not exist.');
        return $model;
    }

    /**
     * Performs the AJAX validation.
     * @param CModel the model to be validated
     */
    protected function performAjaxValidation($model) {
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'colocaciones-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }

    public function actionAsignarColocaciones() {
        $this->render('create', array('model' => new Colocaciones, 'cheques' => new Cheques, 'clientes' => new Clientes));
    }

    public function actionRecolocacion() {
        $model = new Colocaciones;
        $this->render('createRecolocacion', array(
            'model' => $model, 'cheques' => new Cheques, 'clientes' => new Clientes)
        );
    }

    public function actionEditarColocacion() {
        if (isset($_POST['idCheque'])) {
            $this->redirect(array('colocaciones/recolocar', 'id' => $_POST['idCheque'], 'idCliente' => $_POST['idCliente']));
        }
//            $model = $this->loadModel($_POST['idColocacion']);
//            $cheques = Cheques::model()->findByPk($model->chequeId);
//            $clientes = new Clientes();
//            $this->render('update', array(
//                'model' => $model, 'cheques' => $cheques, 'clientesDataProvider' => $clientes->getClientesColocacion($_POST['idColocacion']))
//            );
//        } else {
//            $this->render('create', array(
//                'model' => new Colocaciones, 'cheques' => new Cheques, 'clientes' => new Clientes)
//            );
//        }
        else
            $this->redirect('create');
    }

    public function actionRecolocar() {
        if (isset($_GET['id'])) {

            $model = Colocaciones::model()->find('chequeId=:chequeId', array('chequeId' => $_GET['id']));

            $cheques = Cheques::model()->findByPk($_GET['id']);
            $detalleColocaciones = new DetalleColocaciones();
            $cliente = Clientes::model()->findByPk($_GET['idCliente']);
            //$clientesDataProvider = $clientes->getClientesColocacion($model->id);
            $this->render('update', array(
                'originalModel' => $model, 'nuevoModel' => new Colocaciones, 'cheques' => $cheques, 'detalleColocaciones' => $detalleColocaciones->getDetalleColocaciones($model->id, $cliente->id), 'cliente' => $cliente)
            );
        }
    }

    public function actionRealizarRecolocacion() {
        $model = new Colocaciones;
        // Uncomment the following line if AJAX validation is needed
        // $this->performAjaxValidation($model);

        if (isset($_POST['Colocaciones'])) {
            $model->attributes = $_POST['Colocaciones'];
            $model->fecha = Date("Y-m-d");
            $model->estado = Colocaciones::ESTADO_ACTIVA;

            $connection = Yii::app()->db;
            $command = Yii::app()->db->createCommand();
            $transaction = $connection->beginTransaction();
            try {
                if ($model->save()) {

                    $originalModel = Colocaciones::model()->findByPk($model->colocacionAnteriorId);
                    $originalModel->estado = Colocaciones::ESTADO_INACTIVA;
                    $originalModel->save();

                    $colocacionId = $model->id;
//                    $cheques = Cheques::model()->findByPk($model->chequeId);
//                    $cheques->estado = Cheques::TYPE_EN_CARTERA_COLOCADO;
//                    $cheques->save();
                    $sql = "INSERT INTO detalleColocaciones (colocacionId, clienteId, monto, tasa) 
						VALUES(:colocacionId, :clienteId, :monto, :tasa)";
                    $command = $connection->createCommand($sql);
                    $listaDetalleColocaciones = explode(',', $_POST['detallesColocaciones']);
                    for ($i = 0; $i < count($listaDetalleColocaciones); $i = $i + 5) {
                        $command->bindValue(":colocacionId", $colocacionId, PDO::PARAM_STR);
                        $command->bindValue(":clienteId", $listaDetalleColocaciones[$i], PDO::PARAM_STR);
                        $command->bindValue(":monto", Utilities::Unformat($listaDetalleColocaciones[$i + 2]), PDO::PARAM_STR);
                        $command->bindValue(":tasa", $listaDetalleColocaciones[$i + 3], PDO::PARAM_STR);
                        $command->execute();
                    }
                    $sql = "INSERT INTO ctacteClientes 
                                            (tipoMov, conceptoId, clienteId, productoId, descripcion, monto, fecha, operacionRelacionada, userStamp, timeStamp, sucursalId) 
                                            VALUES (:tipoMov, :conceptoId, :clienteId, :productoId, :descripcion, :monto, :fecha, :operacionRelacionada, :userStamp, :timeStamp, :sucursalId)";


                    $command = $connection->createCommand($sql);
                    $tipoMov = 1; //debito
                    $conceptoId = 9; //
                    $productoId = 1; //compra de cheques
                    $descripcion = "REColocacion";
                    $fecha = Date("Y-m-d");
                    $operacionRelacionada = "REColocacion";
                    $userStamp = Yii::app()->user->model->username;
                    $timeStamp = Date("Y-m-d h:m:s");
                    $sucursalId = Yii::app()->user->model->sucursalId;

                    for ($i = 0; $i < count($listaDetalleColocaciones); $i = $i + 5) {
                        $command->bindValue(":tipoMov", $tipoMov, PDO::PARAM_STR);
                        $command->bindValue(":conceptoId", $conceptoId, PDO::PARAM_STR);
                        $command->bindValue(":clienteId", $listaDetalleColocaciones[$i], PDO::PARAM_STR);
                        $command->bindValue(":productoId", $productoId, PDO::PARAM_STR);
                        $command->bindValue(":descripcion", $descripcion, PDO::PARAM_STR);

                        $valorActual = $model->calculoValorActual(Utilities::Unformat($listaDetalleColocaciones[$i + 2]), Utilities::ViewDateFormat($model->cheque->fechaPago), $listaDetalleColocaciones[$i + 3], $model->cheque->clearing);

                        $command->bindValue(":monto", $valorActual, PDO::PARAM_STR);
                        $command->bindValue(":fecha", $fecha, PDO::PARAM_STR);
                        $command->bindValue(":operacionRelacionada", $operacionRelacionada, PDO::PARAM_STR);
                        $command->bindValue(":userStamp", $userStamp, PDO::PARAM_STR);
                        $command->bindValue(":timeStamp", $timeStamp, PDO::PARAM_STR);
                        $command->bindValue(":sucursalId", $sucursalId, PDO::PARAM_STR);
                        $command->execute();
                    }

                    $transaction->commit();
                    $this->redirect(array('view', 'id' => $model->id));
                }
            } catch (Exception $e) { // an exception is raised if a query fails
                $transaction->rollBack();
            }
        }

        $this->render('create', array(
            'model' => $model, 'cheques' => new Cheques, 'clientes' => new Clientes)
        );
    }

}
