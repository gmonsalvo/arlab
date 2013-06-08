<?php

class RecibosController extends Controller {

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
                'actions' => array('create', 'update', 'addSaldo', 'cancelar', 'guardarRecargo', 'admin', 'reciboPDF'),
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

    public function actionGuardarRecargo() {
        $model = $this->loadModel($_POST['reciboId']);
        $model->recargo = $_POST['recargo'];
        if ($model->save()) {
            echo "ok";
        }
    }

    /**
     * Creates a new model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     */
    public function actionCreate() {
        $model = new Recibos;
        $model->clienteId= $_GET['clienteId'];
        $model->fecha=Date('Y-m-d');
        $model->montoTotal=0.00;
        //echo $model->getUltimoNumero(); 
        if ($model->save())
              $this->redirect(array('update', 'id' => $model->id));
     }

        
    

    /**
     * Creates a new model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     */
    public function actionAddSaldo() {
        $model = new RecibosNotaVenta;

        // Uncomment the following line if AJAX validation is needed
        // $this->performAjaxValidation($model);

        if (isset($_POST['RecibosNotaVenta'])) {
            //tomamos los valores del formulario
            $model->reciboId = $_POST['RecibosNotaVenta']['reciboId'];
            $model->notaVentaId = $_POST['RecibosNotaVenta']['notaVentaId'];
            $model->monto = $_POST['RecibosNotaVenta']['monto'];
            $model->recargo = $_POST['RecibosNotaVenta']['recargo'];

            if ($model->save())
                $this->redirect(array('update', 'id' => $model->reciboId));
        }

        $this->render('addSaldo', array(
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
        $transaction = $model->dbConnection->beginTransaction();
        try {

            if (isset($_POST['Recibos'])) {
                $model->attributes = $_POST['Recibos'];
                              
                $ultimo = $model->getUltimoNumero("1");
                 //actualizamos el numero de recibo en la tabla documentos
                $sql = "update documentos set ultimoNumero='" . ($ultimo+1). "' where tipoDocumento='REC' and sucursal=1";
                $result = Yii::app()->db->createCommand($sql)->execute();
                if ($result==0){
                     $error = 'Error al actualizar el numero de recibo actual';
                            throw new Exception($error);
                }
                //seteamos el estado de finalizado en el recibo
                $model->sucursal='1';
                $model->numero=$ultimo;
                $model->userStamp=Yii::app()->user->model->username;
                $model->estado = 1;
                if ($model->save()) {
                   
                    //borramos los registros de pagos 
                    //acreditamos en cuenta corriente
                    $saldos = $model->RecibosNotaVenta;
                    foreach ($saldos as $saldo) {
                        //metemos el registro en cuenta corriente
                        $notaVenta = NotaVenta::model()->findBypk($saldo->notaVentaId);
                        $saldoAnterior=$notaVenta->getSaldo();

                        $ctacte = new CtaCteClientes();
                        $ctacte->tipoMov = 1; //credito
                        $ctacte->notaVentaId = $saldo->notaVentaId;
                        $ctacte->fecha = date("Y-m-d");
                        $ctacte->conceptoId = 10;
                        $ctacte->monto = $saldo->monto;
                        //antes del recargo si con lo que paga cancelamos la nota de venta
                        //ponemos el estado correspondiente
                        
                         $diferencia=$saldoAnterior-$saldo->monto;
                        if ($diferencia<=0) {
                            $notaVenta->estado = 1;
                        } else {
                            $notaVenta->estado = 0;
                        }
                        if (!$notaVenta->save()) {
                            $error = 'Error al Guardar la nota de Venta:' . $notaVenta->getErrors();
                            throw new Exception($error);
                        }

                        //si tiene recargo tenemos que reflejarlo en la ctacte
                        if ($saldo->recargo > 0) {

                            //debito 
                            $ctacteRd = new CtaCteClientes();
                            $ctacteRd->tipoMov = 0;
                            $ctacteRd->notaVentaId = $saldo->notaVentaId;
                            $ctacteRd->fecha = date("Y-m-d");
                            $ctacteRd->conceptoId = 14;
                            $ctacteRd->monto = $saldo->recargo;
                            $ctacteRd->userStamp = Yii::app()->user->model->username;
                            $ctacteRd->timeStamp = Date("Y-m-d h:m:s");
                            if (!$ctacteRd->save()) {
                                $error = 'Error al Guardar El credito por REcargo en Ctacte:' . $ctacteRd->getErrors();
                                throw new Exception($error);
                            }
                            //credito
                            $ctacteRc = new CtaCteClientes();
                            $ctacteRc->tipoMov = 1;
                            $ctacteRc->notaVentaId = $saldo->notaVentaId;
                            $ctacteRc->fecha = date("Y-m-d");
                            $ctacteRc->conceptoId = 10;
                            $ctacteRc->monto = $saldo->recargo;
                            $ctacteRc->userStamp = Yii::app()->user->model->username;
                            $ctacteRc->timeStamp = Date("Y-m-d h:m:s");
                            if (!$ctacteRc->save()) {
                                $error = 'Error al Guardar El credito por REcargo en Ctacte:' . $ctacteRc->getErrors();
                                throw new Exception($error);
                            }
                        }
                        $ctacte->userStamp = Yii::app()->user->model->username;
                        $ctacte->timeStamp = Date("Y-m-d h:m:s");
                        if (!$ctacte->save()) {
                            $error = 'Error al Guardar El credito en Ctacte:' . $ctacte->getErrors();
                            throw new Exception($error);
                        }
                    }
                    
                    //flujo de fondos
                    $pagos = $model->formaPago;
                    $cantidad=count($pagos);
                    foreach ($pagos as $pago) {
                        
                        //insertamos en la cajaDiaria
                        $flujoFondos= new FlujoFondos();
                        $flujoFondos->fecha=date("Y-m-d");
                        $flujoFondos->cuentaId=Yii::app()->params['cuentaCajaDiaria'];
                        $flujoFondos->tipoMov=1; //ingreso
                        $flujoFondos->monto=$pago->monto;
                        $flujoFondos->conceptoId=7; //pagos por abonos
                        $flujoFondos->tipoFondoId=$pago->tipoFormaPago;
                        $flujoFondos->descripcion="Cliente:".$model->cliente->razonSocial."  Referencia (".$cantidad."): ".$pago->numeroReferencia." | <a  target=new  href='/arlab/index.php/recibos/ReciboPDF/".$model->id."'> Recibo</a>";
                        $flujoFondos->monedaId=1; //pesos
                        $flujoFondos->userStamp=Yii::app()->user->model->username;
                        $flujoFondos->timeStamp= Date("Y-m-d h:m:s");

                        if (!($flujoFondos->save()))
                               {
                               $error = 'Error al Registrar el Flujo de Fondos:' . $model->getErrors();
                               throw new Exception($error);      
                            }

                    }
                 
                $transaction->commit();
                    //redirijimos a la hoja del cliente
                $this->actionFinal($model->id);
                } else {
                    $error = 'Error al Guardar el estado del recibo:' . $model->getErrors();
                    throw new Exception($error);
                }
            } else {
                $this->render('_formUpdate', array('model' => $model,));
            }
        } catch (Exception $e) {
            echo(var_dump($e));
            $transaction->rollBack();
            Yii::app()->end();
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
     * Cancela un recibo borrando el registro creado y los relacionados
     * If deletion is successful, the browser will be redirected to the 'admin' page.
     * @param integer $id the ID of the model to be deleted
     */
    public function actionCancelar($id) {
        //borramos el recibo
        // we only allow deletion via POST request
        $model = $this->loadModel($id);
        $clienteId = $model->clienteId;
        //vemos primero si el recibo no esta terminado, si lo esta no dejamos 
        //borrarlo.
        if ($model->estado==0){
            
            $model->delete();
            //borramos los registros de pagos 
            $sql = "delete from formaPagoRecibos where reciboId=" . $id;
            $result = Yii::app()->db->createCommand($sql)->execute();
            //borramos las notas de ventas asociadas 		
            $sql = "delete from recibosNotaVenta where reciboId=" . $id;
            $result = Yii::app()->db->createCommand($sql)->execute();
            Yii::app()->user->setFlash('success', 'El recibo se cancelo');
        }else{

            Yii::app()->user->setFlash('error', 'El recibo no se puede cancelar ya que esta cerrado');
        }
        

        $this->redirect(array('clientes/view', 'id' => $clienteId));

    }

    /**
     * Lists all models.
     */
    public function actionIndex() {
        $dataProvider = new CActiveDataProvider('Recibos');
        $this->render('index', array(
            'dataProvider' => $dataProvider,
        ));
    }

    /**
     * Manages all models.
     */
    public function actionAdmin() {
        $model = new Recibos('search');
        $model->unsetAttributes();  // clear any default values
        if (isset($_GET['Recibos']))
            $model->attributes = $_GET['Recibos'];

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
        $model = Recibos::model()->findByPk((int) $id);
        if ($model === null)
            throw new CHttpException(404, 'The requested page does not exist.');
        return $model;
    }

    /**
     * Performs the AJAX validation.
     * @param CModel the model to be validated
     */
    protected function performAjaxValidation($model) {
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'recibos-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }

    public function actionReciboPdf($id) {

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
        $pdf->Cell(0, 1, 'Recibo', 0, 1, 'C');
        $pdf->Ln();

        $html = 'Fecha: ' . $model->fecha . '
                       <br/>
                       Recibo Nro: ' . str_pad($model->sucursal, 4, "0", STR_PAD_LEFT) . "-" . str_pad($model->numero, 7, "0", STR_PAD_LEFT) . '
                       <br/>
                       Cliente: ' . $model->cliente->razonSocial . '
                       <br/>
                       <br/>
                       <br/>
                       Saldos Pendientes
                       <br/>
                       <br/>
                        ';
        if (count($model->RecibosNotaVenta) > 0) {
            $pdf->SetFont("times", "b", 12);
            $html.= '<table><tr><td>Periodo</td><td>Detalle</td><td>Monto</td><td>Recargo</td></tr>';
            $pdf->SetFont("times", 12);
            foreach ($model->RecibosNotaVenta as $nv) {
                $html.="<tr><td>" . $nv->NotaVenta->periodo . "</td><td>" . $nv->NotaVenta->detalle . "</td><td>" . Utilities::MoneyFormat($nv->monto) . "</td><td>" . Utilities::MoneyFormat($nv->recargo) . "</td></tr>";
            }
        }$pdf->SetFont("times", "b", 12);
        $html.=' 
              <br/>
              <br/>    
              Forma de Pago
              <br/>
              <br/>  
            ';

        if (count($model->formaPago) > 0) {
            $html.= '<table><tr><td>Fecha</td><td>Tipo Forma Pago</td><td>Referencia</td><td>Monto</td></tr>';
            $pdf->SetFont("times", 12);
            foreach ($model->formaPago as $fp) {
                $html.="<tr><td>" . $fp->fecha . "</td><td>" . $fp->DescripcionFormaPago->nombre . "</td><td>" . $fp->numeroReferencia . "</td><td>" . Utilities::MoneyFormat($fp->monto) . "</td></tr>";
            }
        }
        $html.='   <br/>
                       <br/>
                       Monto Total: ' . Utilities::MoneyFormat($model->montoTotal);


        $html.='</tbody></table>';

        $pdf->writeHTML($html, true, false, true, false, '');
      
        $pdf->Output($id . ".pdf", "I");
    }

    public function actionFinal($id) {
        $model = $this->loadModel($id);
        echo '<script type="text/javascript" language="javascript"> 
                    window.open("reciboPDF/' . $id . '");
                    </script>';

        $this->redirect(array('recibos/admin'));
        $model->unsetAttributes();
    }

}
