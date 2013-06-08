<?php

class PesificacionesController extends Controller {

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
                'actions' => array('create', 'update', 'resumenPDF', 'admin', 'getDetallePesificaciones', 'acreditar', 'resumenPDF'),
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
        echo '<script type="text/javascript" language="javascript"> 
		window.open("resumenPDF/' . $id . '");
		</script>';
        $this->render('view', array(
            'model' => $this->loadModel($id),
        ));
    }

    /**
     * Creates a new model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     */
    public function actionCreate() {

        $model = new Pesificaciones;

        $cheques = new Cheques('search');
        $cheques->unsetAttributes();  // clear any default values
        if (isset($_GET['Cheques']))
            $cheques->attributes = $_GET['Cheques'];


        // Uncomment the following line if AJAX validation is needed
        // $this->performAjaxValidation($model);

        if (isset($_POST['Pesificaciones'])) {
            $model->attributes = $_POST['Pesificaciones'];
            $model->fecha = Utilities::MysqlDateFormat($model->fecha);
            $model->montoAcreditar = 0;
            $model->montoGastos = 0;
            $model->estado = Pesificaciones::ESTADO_ABIERTO;
            $connection = Yii::app()->db;
            $command = Yii::app()->db->createCommand();
            $transaction = $connection->beginTransaction();
            try {
                if ($model->save()) {
                    $pesificacionId = $model->id;
                    $sql = "INSERT INTO detallePesificaciones (pesificacionId, chequeId) VALUES(:pesificacionId, :chequeId)";
                    $command = $connection->createCommand($sql);
                    $listaDetallePesificaciones = explode(';', $_POST['detallesPesificaciones']);
                    for ($i = 1; $i < count($listaDetallePesificaciones); $i++) {
                        $command->bindValue(":pesificacionId", $pesificacionId, PDO::PARAM_STR);
                        $command->bindValue(":chequeId", $listaDetallePesificaciones[$i], PDO::PARAM_STR);
                        $command->execute();
                        $cheques = Cheques::model()->findByPk($listaDetallePesificaciones[$i]);
                        $cheques->estado = Cheques::TYPE_EN_PESIFICADOR;
                        $cheques->save();
                    }
                    $transaction->commit();
                    $cheques = new Cheques('search');
                    $cheques->unsetAttributes();  // clear any default values
                    echo '<script type="text/javascript" language="javascript"> 
                                                window.open("ResumenPDF/' . $model->id . '");
                                                </script>';
                }
            } catch (Exception $e) { // an exception is raised if a query fails
                $transaction->rollBack();
            }
        }

        $this->render('create', array(
            'model' => $model, 'cheques' => $cheques, 'valor' => 'prueba'
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

        if (isset($_POST['Pesificaciones'])) {
            $model->attributes = $_POST['Pesificaciones'];
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
        $dataProvider = new CActiveDataProvider('Pesificaciones');
        $this->render('index', array(
            'dataProvider' => $dataProvider,
        ));
    }

    /**
     * Manages all models.
     */
    public function actionAdmin() {
        $model = new Pesificaciones('search');
        $model->unsetAttributes();  // clear any default values
        if (isset($_GET['Pesificaciones']))
            $model->attributes = $_GET['Pesificaciones'];

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
        $model = Pesificaciones::model()->findByPk($id);
        if ($model === null)
            throw new CHttpException(404, 'The requested page does not exist.');
        return $model;
    }

    /**
     * Performs the AJAX validation.
     * @param CModel the model to be validated
     */
    protected function performAjaxValidation($model) {
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'pesificaciones-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }

    public function actionGetDetallePesificaciones() {
        if (isset($_POST['pesificacionesId'])) {
            $model = $this->loadModel($_POST['pesificacionesId']);
            $monto = 0;
            foreach ($model->detallePesificaciones as $detallePesificaciones) {
                $monto+=$detallePesificaciones->cheque->montoOrigen;
            }
            $gastosPesificacion = Utilities::MoneyFormat(($monto * $model->pesificador->tasaDescuento) / 100);
            $monto = Utilities::MoneyFormat($monto);
            $dataProvider = $model->searchById();
            $render = $this->renderPartial('/detallePesificaciones/verDetalles', array('dataProvider' => $dataProvider, 'model' => new Pesificaciones), true);
            echo $render . ';' . $monto . ';' . $model->montoAcreditar . ';' . $model->montoGastos . ';' . $gastosPesificacion;
        }
    }

    public function actionAcreditar() {
        if (isset($_POST['id'])) {
            $model = $this->loadModel($_POST['id']);
            $model->montoAcreditar = $_POST['montoAcreditar'];
            $model->montoGastos = $_POST['montoGastos'];
            $model->estado = Pesificaciones::ESTADO_CERRADO;

            $connection = Yii::app()->db;
            $command = Yii::app()->db->createCommand();
            $transaction = $connection->beginTransaction();
            try {
                if ($model->save()) {
                    $tmpcheques = new TmpCheques();
                    $sql = "INSERT INTO ctacteClientes 
                                            (tipoMov, conceptoId, clienteId, productoId, descripcion, monto, fecha, operacionRelacionada, userStamp, timeStamp, sucursalId) 
                                            VALUES (:tipoMov, :conceptoId, :clienteId, :productoId, :descripcion, :monto, :fecha, :operacionRelacionada, :userStamp, :timeStamp, :sucursalId)";

                    $tipoMov = 0; //credito
                    $conceptoId = 9; //Ingreso de fondos
                    $productoId = 1; //compra de cheques
                    $descripcion = "Pesificacion";
                    $fecha = Date("Y-m-d");
                    $operacionRelacionada = "Pesificacion";
                    $userStamp = Yii::app()->user->model->username;
                    $timeStamp = Date("Y-m-d h:m:s");
                    $sucursalId = Yii::app()->user->model->sucursalId;

                    $valor = 'paso';
                    Yii::trace($valor, 'application.controllers.PesificacionesController');
                    foreach ($model->detallePesificaciones as $detallePesificaciones) {
//                        $command = $connection->createCommand($sql);
//                        $criteria->condition='chequeId='.$detallePesificaciones->cheque->id;
                        //$colocacion = Colocaciones::model()->findAll($criteria);
                        $colocaciones = $command->select('*')->from('colocaciones')->where('chequeId=:chequeId', array(':chequeId' => $detallePesificaciones->cheque->id))->queryAll();
                        //$colocacion = Colocaciones::model()->find('chequeId=:chequeId', array(':chequeId' => $detallePesificaciones->cheque->id));
                        Yii::trace($command->getText(), 'application.controllers.PesificacionesController');
                        $command->reset();
                        if (count($colocaciones) > 0) {
                            //$valor=count($colocaciones);   
                            $colocacion = $colocaciones[0];
                            $detalleColocaciones = $command->select('*')->from('detalleColocaciones')->where('colocacionId=' . $colocacion['id'])->queryAll();
                            $valor = $command->getText() . 'cantidad' . count($detalleColocaciones);
                            $command = $connection->createCommand($sql);
                            for ($i = 0; $i < count($detalleColocaciones); $i++) {

                                $command->bindValue(":tipoMov", $tipoMov, PDO::PARAM_STR);
                                $command->bindValue(":conceptoId", $conceptoId, PDO::PARAM_STR);
                                $command->bindValue(":clienteId", $detalleColocaciones[$i]['clienteId'], PDO::PARAM_STR);
                                $command->bindValue(":productoId", $productoId, PDO::PARAM_STR);
                                $command->bindValue(":descripcion", $descripcion, PDO::PARAM_STR);
                                $command->bindValue(":monto", $detalleColocaciones[$i]['monto'], PDO::PARAM_STR);
                                $command->bindValue(":fecha", $fecha, PDO::PARAM_STR);
                                $command->bindValue(":operacionRelacionada", $operacionRelacionada, PDO::PARAM_STR);
                                $command->bindValue(":userStamp", $userStamp, PDO::PARAM_STR);
                                $command->bindValue(":timeStamp", $timeStamp, PDO::PARAM_STR);
                                $command->bindValue(":sucursalId", $sucursalId, PDO::PARAM_STR);
                                $command->execute();
                                $valor = '$command->getText()';
                                $cheques = Cheques::model()->findByPk($detallePesificaciones->cheque->id);
                                $cheques->estado = Cheques::TYPE_VENDIDO;
                                $cheques->save();
                            }
                        }else
                            $valor = count($colocaciones);
                        //$valor='lala';
                    }
                    //$this->redirect('admin');
                }
                $transaction->commit();
            } catch (Exception $e) { // an exception is raised if a query fails
                $transaction->rollBack();
            }
            $this->render('create', array(
                'model' => $model, 'cheques' => new Cheques, 'valor' => $valor
            ));
        }
    }

    public function actionResumenPDF($id) {
        $convertirNumero = new n2t();
        $model = $this->loadModel($id);
        $pdf = Yii::createComponent('application.extensions.tcpdf.ETcPdf', 'P', 'cm', 'A4', true, 'UTF-8');
        $pdf->SetCreator(PDF_CREATOR);
        $pdf->SetAuthor("CAPITAL ADVISORS");
        $pdf->SetTitle("Resumen de la Pesificacion");
        $pdf->SetKeywords("TCPDF, PDF, example, test, guide");
        $pdf->setPrintHeader(false);
        $pdf->setPrintFooter(false);
        $pdf->AliasNbPages();
        $pdf->AddPage();
        $pdf->SetFont("times", "B", 12);
        $pdf->Write(0, $model->fecha, '', 0, 'R', true, 0, false, false, 0);
        $pdf->Cell(0, 3, 'Detalles de la Pesificacion', 0, 1, 'C');

        $html = '
			<table border="1">
				<thead>
				<tr>
				<th>Numero Cheque</th><th>Fecha Pago</th><th>Monto</th><th>Tipo</th>
			</tr>
			</thead>';
        $monto = 0;

        foreach ($model->detallePesificaciones as $detallePesificaciones) {
            $html.="<tbody><tr>
					<td>" . $detallePesificaciones->cheque->numeroCheque . "</td><td>" . $detallePesificaciones->cheque->fechaPago . "</td><td>" . Utilities::MoneyFormat($detallePesificaciones->cheque->montoOrigen) . "</td><td>" . $detallePesificaciones->cheque->getTypeDescription("tipoCheque") . "</td></tr>";
            $monto+=$detallePesificaciones->cheque->montoOrigen;
        }
        $html.='</tbody></table>';
        $html.='<br>';
        $html.='Monto: $' . Utilities::MoneyFormat($monto) . '<br/><br/>';
        $html.='Pesificador: ' . $model->pesificador->denominacion . '<br/><br/>';
        $html.='% Pesificacion: ' . ($model->pesificador->tasaDescuento) . '<br/><br/>';
        $gastoTotal = ($monto * $model->pesificador->tasaDescuento) / 100;
        $total = $monto - $gastoTotal;
        $html.='TOTAL: ' . Utilities::MoneyFormat($total);
        $pdf->writeHTML($html, true, false, true, false, '');
        $pdf->Output($model->id . ".pdf", "I");
    }

}
