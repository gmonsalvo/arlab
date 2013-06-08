<?php

class ServiciosVoipController extends Controller {

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
                'actions' => array('create', 'update', 'admin', 'mostrarConsumos', 'detalleConsumos', 'exportPdf'),
                'users' => array('@'),
            ),
            array('allow', // allow admin user to perform 'admin' and 'delete' actions
                'actions' => array('delete', 'generarDebitos', 'generarConsumos', 'mostrarConsumos', 'detalleConsumos'),
                'users' => array('gmonsalvo', 'khaure'),
            ),
            array('allow', // allow admin user to perform 'admin' and 'delete' actions
                'actions' => array('delete'),
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
        $model = new ServiciosVoip;


// Uncomment the following line if AJAX validation is needed
// $this->performAjaxValidation($model);
        $transaction = $model->dbConnection->beginTransaction();
        try {
            if (isset($_POST['ServiciosVoip'])) {
                $model->attributes = $_POST['ServiciosVoip'];
                $this->userStamp = Yii::app()->user->model->username;
                $this->timeStamp = Date("Y-m-d h:m:s");
                if ($model->save()) {

                    if (Yii::app()->params->generaDebitos) {

                        $fechaArray = explode("-", $model->fechaInstalacion);
//armamos el periodo
                        $dia = str_pad($fechaArray[2], '2', "0", STR_PAD_LEFT);
                        $mes = $fechaArray[1];
                        $anio = $fechaArray[0];
                        $i = $mes;
                        while ($i <= 12) {
//generamos las notas de venta para los periodos desde
//la fecha de alta hasta el fin del periodo
                            echo "Hasta Aqui";
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
                                $notaVenta->detalle = "Abono Proporcional Telefonia VOIP";
                                $notaVenta->monto = ($model->costoServicio / 30) * (30 - $dia) * 1.21;
                            } else {
                                $notaVenta->detalle = "Abono Telefonia VOIP";
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
                            } else {

                                echo "Error al Guardar la nota de Venta";
                                $transaction->rollBack();
                            }
                            $i++;
                        }
                    }

                    $transaction->commit();
                    $this->redirect(array('/clientes/view', 'id' => $model->clienteId));
                } else {
                    echo "Error al guardar el servicio VOIP";
                    $transaction->rollBack();
                }
            }
            $this->render('create', array(
                'model' => $model,
            ));
        } catch (Exception $e) {
            print_r($e);
            $transaction->rollBack();
        }
    }

    public function actionGenerarDebitos() {
        $connection = Yii::app()->db;
        $transaction = $connection->beginTransaction();
        try {


            $serviciosVoip = new ServiciosVoip();

            foreach ($serviciosVoip->findAll() as $si) {

              if (($si->cliente->estado == Clientes::ESTADO_ACTIVO) or ($si->cliente->estado == Clientes::ESTADO_SUSPENDIDO)) {

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
                        $control="periodo='".$anio . str_pad($i, '2', "0", STR_PAD_LEFT)."' AND servicioId='".$si->id."'";
                        if (!($notaVenta->exists($control))){
                            $notaVenta->fecha = date("d/m/Y");
                            $notaVenta->fechaVencimiento = "10/" . str_pad($i, '2', "0", STR_PAD_LEFT) . "/" . $anio;
                            $notaVenta->clienteId = $si->clienteId;
                            $notaVenta->servicioId = $si->id;
                            $notaVenta->periodo = $anio . str_pad($i, '2', "0", STR_PAD_LEFT);
    //tenemos en cuenta que si es el mes del alta tenemos que 
    //generar un proporional
                            $notaVenta->detalle = "Abono Servicio Voip";
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
                         } // fin del control de nota de venta existente   
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

    public function actionGenerarConsumos() {
        $connection = Yii::app()->db;
        $transaction = $connection->beginTransaction();
        try {
            $periodo = $_GET['periodo'];
//convertimos el periodo en formato de fecha de inicio y fecha de fin
            $anio = substr($periodo, 0, 4);
            $mes = substr($periodo, 4, 2);
            $serviciosVoip = new ServiciosVoip();

            foreach ($serviciosVoip->findAll() as $si) {

                if (($si->cliente->estado == Clientes::ESTADO_ACTIVO) or ($si->cliente->estado == Clientes::ESTADO_SUSPENDIDO)) {

//verificamos que no este generado ya el consumo    
//armamos el periodo
                    $consumo = $si->obtenerConsumo($anio . "-" . $mes . "-01", $anio . "-" . $mes . "-31");

                   
//generamos las notas de venta para los periodos desde
//la fecha de alta hasta el fin del periodo
//echo "<b>Periodo:</b>" . $anio . str_pad($i, '2', "0", STR_PAD_LEFT) . "<br>";
                
                    if (NotaVenta::model()->debitoGenerado($si->clienteId, $anio . str_pad($mes, '2', "0", STR_PAD_LEFT), number_format($consumo['totalPagar'] * 1.21,2))==false) 
                    {
                        $notaVenta = new NotaVenta();
                        $notaVenta->fecha = date("d/m/Y");
                        $notaVenta->fechaVencimiento = "10/" . str_pad($mes, '2', "0", STR_PAD_LEFT) . "/" . $anio;
                        $notaVenta->clienteId = $si->clienteId;
                        $notaVenta->servicioId = $si->id;
                        $notaVenta->periodo = $anio . str_pad($mes, '2', "0", STR_PAD_LEFT);
//tenemos en cuenta que si es el mes del alta tenemos que 
//generar un proporional
                        $notaVenta->detalle = "Consumos Voip Periodo:" . $periodo . " Cant. Llamadas: " . $consumo['cantidadLlamadas'] . " Minutos Consumidos:" . $consumo['minutosTotales'];
                        $notaVenta->monto = round($consumo['totalPagar'] * 1.21,2);
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
                            echo "Error al guardar la nota de venta";
                            print_r($notaVenta->getErrors());
                            print_r($notaVenta);
                            $transaction->rollBack();
                            Yii::app()->end();
                        }
                     echo $si->id . "-" . $si->cliente->razonSocial . " Consumo:" . $consumo['totalPagar'] . " Cantidad Llamadas:" . $consumo['cantidadLlamadas'] . "<br>";    
                    } //fin del if del control de debito ya genere
                } // fin del if del control de cliente activo
            }
            $transaction->commit();
            echo "Fin.";
        } catch (Exception $e) {
            echo $e;
        }
    }

    public function actionMostrarConsumos() {
       
        try {
            $periodo = $_GET['periodo'];
//convertimos el periodo en formato de fecha de inicio y fecha de fin
            $anio = substr($periodo, 0, 4);
            $mes = substr($periodo, 4, 2);
            $serviciosVoip = new ServiciosVoip();
            $totalRecaudacion = 0.00;
            foreach ($serviciosVoip->findAll() as $si) {
//armamos el periodo
                $consumo = $si->obtenerConsumo($anio . "-" . $mes . "-01", $anio . "-" . $mes . "-31");
                if (NotaVenta::model()->debitoGenerado($si->clienteId, $anio . str_pad($mes, '2', "0", STR_PAD_LEFT), number_format($consumo['totalPagar'] * 1.21,2)))
                {       
                    echo $si->id . "-" . $si->cliente->razonSocial . " Consumo, Ya generado:" . $consumo['totalPagar'] . " Cantidad Llamadas:" . $consumo['cantidadLlamadas'] . "<br>";
                }else{
                    echo $si->id . "-" . $si->cliente->razonSocial . " Consumo:" . $consumo['totalPagar'] . " Cantidad Llamadas:" . $consumo['cantidadLlamadas'] . "<br>";      
               }
                $totalRecaudacion = $totalRecaudacion + $consumo['totalPagar'];
            }

            echo "<br>Total Recaudado:" . $totalRecaudacion;
        } catch (Exception $e) {
            echo $e;
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

        if (isset($_POST['ServiciosVoip'])) {
            $model->attributes = $_POST['ServiciosVoip'];
            $model->lastUserUpdate = Yii::app()->user->model->username;
            if ($model->save())
                $this->redirect(array('/clientes/view', 'id' => $model->clienteId));
        }

        $this->render('update', array(
            'model' => $model,
        ));
    }

    public function actionDetalleConsumos($periodo, $id) {
        $model = $this->loadModel($id);
//$periodo = $_GET['periodo'];
//convertimos el periodo en formato de fecha de inicio y fecha de fin
        $anio = substr($periodo, 0, 4);
        $mes = substr($periodo, 4, 2);
        $llamadas = $model->detalleConsumo($anio . "-" . $mes . "-01", $anio . "-" . $mes . "-31");

// Uncomment the following line if AJAX validation is needed
// $this->performAjaxValidation($model);

        $this->renderPartial('detalleConsumos', array(
            'model' => $model, 'llamadas' => $llamadas
            , 'anio' => $anio, 'mes' => $mes));
    }

    public function actionExportPdf($id, $periodo) {

        $model = $this->loadModel($id);


        $pdf = Yii::createComponent('application.extensions.tcpdf.ETcPdf', 'P', 'cm', 'A4', true, 'UTF-8');
        $pdf->SetCreator(PDF_CREATOR);
        $pdf->SetAuthor("ARLAB TI");
        $pdf->SetTitle("Detalle de Llamadas");
        $pdf->SetKeywords("TCPDF, PDF, example, test, guide");
        $pdf->setPrintHeader(false);
        $pdf->setPrintFooter(false);
        $pdf->AliasNbPages();
        $pdf->AddPage();
        $pdf->SetFont("times", "b", 12);
//$pdf->Write(0, $model->fecha, '', 0, 'R', true, 0, false, false, 0);
        $pdf->Cell(0, 3, 'Detalle de Llamadas', 0, 1, 'C');
        $pdf->Ln();

        $html = 'Fecha Generacion:' . date("d/m/Y") . '
                    
                       Cliente: ' . $model->cliente->razonSocial . '
                       <br/>
                       <br/>
                       <br/>
                       Detalle de Llamadas
                       <br/>
                       <br/>
                        ';


        $pdf->SetFont("times", "b", 12);
        $html.='<table class = "items">';
        $html.='<thead><tr><th>Fecha/Hora</th><th>Numero Destino</th><th>Duracion</th><th>Tarifa</th><th>Descripcion Tarifa</th><th>Costo Total</th></tr></thead>';
        $html.='<tbody>';

        $periodo = $_GET['periodo'];
//convertimos el periodo en formato de fecha de inicio y fecha de fin
        $anio = substr($periodo, 0, 4);
        $mes = substr($periodo, 4, 2);

        $llamadas = $model->detalleConsumo($anio . "-" . $mes . "-01", $anio . "-" . $mes . "-31");
        $costoTotal=0;
        $cantidadLlamadas=0; 
        foreach ($llamadas as $llamada) {
            $tarifa = $model->obtenerTarifaLlamada($llamada['dst']);
            $html.="<tr><td>" . $llamada['calldate'] .
                    "</td><td>" . $llamada['dst'] .
                    "</td><td>" . $llamada['duracion_min'] .
                    "</td><td>" . $tarifa['precio_venta']*Yii::app()->params->cotizacionDolar .
                    "</td><td>" . $tarifa['descripcion'] .
                    "</td><td>" . $tarifa['precio_venta'] * $llamada['duracion_min']*Yii::app()->params->cotizacionDolar .
                    "</td></tr>";
           $costoTotal=$costoTotal+($tarifa['precio_venta']*$llamada['duracion_min']*Yii::app()->params->cotizacionDolar);
                $cantidadLlamadas++;
            
        }
        $html.="<tr><th colspan=6>Cant. llamadas: ".$cantidadLlamadas."  Costo Llamadas Realizadas:".number_format($costoTotal,2)."  IVA:".number_format($costoTotal*0.21,2)." Costo Total Final:".number_format($costoTotal*1.21,2)."</td></tr>";
        $html.='</tbody></table>';

        $pdf->writeHTML($html, true, false, true, false, '');
        $pdf->Ln();
        $pdf->Output($id . ".pdf", "I");
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
        $dataProvider = new CActiveDataProvider('ServiciosVoip');
        $this->render('index', array(
            'dataProvider' => $dataProvider,
        ));
    }

    /**
     * Manages all models.
     */
    public function actionAdmin() {
        $model = new ServiciosVoip('search');
        $model->unsetAttributes();  // clear any default values
        if (isset($_GET['ServiciosVoip']))
            $model->attributes = $_GET['ServiciosVoip'];

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
        $model = ServiciosVoip::model()->findByPk((int) $id);
        if ($model === null)
            throw new CHttpException(404, 'The requested page does not exist.');
        return $model;
    }

    /**
     * Performs the AJAX validation.
     * @param CModel the model to be validated
     */
    protected function performAjaxValidation($model) {
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'servicios-voip-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }

}
