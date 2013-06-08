<?php

class CambioPlanController extends Controller {

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
                'actions' => array('create', 'update', 'admin', 'finalizar'),
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
        $model = new CambioPlan;

        // Uncomment the following line if AJAX validation is needed
        // $this->performAjaxValidation($model);

        if (isset($_POST['CambioPlan'])) {
            $model->attributes = $_POST['CambioPlan'];
            if ($model->save()) {

                $this->redirect(array('view', 'id' => $model->id));
            }
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

        if (isset($_POST['CambioPlan'])) {
            $model->attributes = $_POST['CambioPlan'];
            if ($model->save())
                $this->redirect(array('view', 'id' => $model->id));
        }

        $this->render('update', array(
            'model' => $model,
        ));
    }

    /**
     * Updates a particular model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id the ID of the model to be updated
     */
    public function actionFinalizar($id) {
        $model = $this->loadModel($id);

        // Uncomment the following line if AJAX validation is needed
        // $this->performAjaxValidation($model);
        //$model->attributes=$_POST['CambioPlan'];
        $model->estado = 1;
        if ($model->save()) {
            //aca tenemos que realizar los cambios
            // Cambiamos el servicio
            $si = ServiciosInternet::model()->findByPK($model->servicioInternetId);
            $si->costoServicio = $model->costoServicio;
            $si->planId = $model->planId;
            if ($si->save()) {
                //Tambien en las notas de venta y la cuenta corriente
                //traemos todas las notas de ventas
                $criteria = new CDbCriteria();
                $criteria->addCondition('servicioId = :servicioId');
                $criteria->addCondition('clienteId = :clienteId');
                $criteria->addCondition('periodo >= :periodo');
                $criteria->params = array(':servicioId' => $model->servicioInternetId,
                    ':clienteId' => $model->servicioInternet->clienteId,
                    ':periodo' => $model->periodoInicio,
                );

                $notas = NotaVenta::model()->findAll($criteria);

                foreach ($notas as $nota) {
                    $nota->monto = $model->costoServicio * 1.21;
                    $nota->detalle = $model->plan->descripcion;
                    if ($nota->getSaldo()>0){
                        $nota->estado=0;
                    }
                    if ($nota->save()) {
                        //actualizamos los debitos en la cuenta corriente para cada
                        //nota de venta
                        $ctacte = CtaCteClientes::model()->findByAttributes(array('notaVentaId' => $nota->id, 'tipoMov' => '0', 'conceptoId' => '13'));
                        $ctacte->monto = $nota->monto;
                        if (!($ctacte->save())) {
                            echo "Error al Guardar en Ctacte";
                            Yii::app()->end();
                        }
                    } else {
                        echo "Error al actualizar la nota de credito";
                        Yii::app()->end();
                    }
                }
                 $this->redirect(array('admin'));
            } // fin if actualizacion del servicio
            else{
                 echo "Error al actualizar el servicio de internet";
                 print_r ($si->getErrors());
                        Yii::app()->end();
            }
           
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
        $dataProvider = new CActiveDataProvider('CambioPlan');
        $this->render('index', array(
            'dataProvider' => $dataProvider,
        ));
    }

    /**
     * Manages all models.
     */
    public function actionAdmin() {
        $model = new CambioPlan('search');
        $model->unsetAttributes();  // clear any default values
        if (isset($_GET['CambioPlan']))
            $model->attributes = $_GET['CambioPlan'];

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
        $model = CambioPlan::model()->findByPk($id);
        if ($model === null)
            throw new CHttpException(404, 'The requested page does not exist.');
        return $model;
    }

    /**
     * Performs the AJAX validation.
     * @param CModel the model to be validated
     */
    protected function performAjaxValidation($model) {
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'cambio-plan-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }

}
