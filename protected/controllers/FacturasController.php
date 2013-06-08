<?php

class FacturasController extends Controller {

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
                'actions' => array('create', 'update', 'facturaPDF', 'final','admin'),
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
        $model = new Facturas;

        // Uncomment the following line if AJAX validation is needed
        // $this->performAjaxValidation($model);

        if ($_GET["id"]) {
            $clienteId = $_GET["id"];
        }
        $cliente = Clientes::model()->findByPk($clienteId);
        if (isset($_POST['Facturas'])) {
            $model->attributes = $_POST['Facturas'];

            $iva = ($_POST["subtotal"] + $model->recargo - $model->descuento) * 21 / 100;
            $total = $_POST["subtotal"] + $model->recargo - $model->descuento + $iva;
            $model->montoTotal = round($total, 2);
            $connection = Yii::app()->db;
            $transaction = $connection->beginTransaction();
            try {
                if ($model->save()) {
                    $facturaId = $model->id;
                    $criteria = new CDbCriteria();
                    $criteria->addInCondition("id", explode(",",$_POST["notaVentaIds"][0]));
                    $notaVentas = NotaVenta::model()->findAll($criteria);
                    $query = "INSERT INTO facturasNotaVenta (facturaId,notaVentaId,monto) VALUES (:facturaId,:notaVentaId)";
                    $command = Yii::app()->db->createCommand();
                    //$command->prepare($query);
                    foreach ($notaVentas as $notaVenta) {
                        // Que la nota de Venta este facturada no implica que este PAGADA
                        $notaVenta->observaciones = "F.Num.".$model->numero."-Monto:".$model->montoTotal;
                        $notaVenta->save();
                        $command->insert("facturasNotaVenta", array("facturaId" => $facturaId, "notaVentaId" => $notaVenta->id,'monto'=>$notaVenta->getSaldoSinIva()));
                    }
                    Yii::app()->user->setFlash('success', 'Factura creada Con Exito');
                   if ($cliente->cuentaOrden == 1){
                          $sucursal=2;
                    }else {
                        $sucursal=1;
                    }

                    if ($cliente->condicionIvaId == 1){
                        $tipoDocumento="FAC_A";
                    }else{
                        $tipoDocumento="FAC_B";
                    }

                    $documento = Documentos::model()->find("tipoDocumento=:tipoDocumento AND sucursal=:sucursal", array(":tipoDocumento" => $tipoDocumento,":sucursal"=>$sucursal) );
        
                    $documento->ultimoNumero = $documento->ultimoNumero + 1;
                    if (!$documento->save()) {
                        Yii::app()->user->setFlash('error', var_dump($documento->getErrors()));
                        $transaction->rollBack();
                    } else {
                        $transaction->commit();
                        Yii::app()->user->setFlash('success', 'Movimiento realizado con exito');
                        $this->actionFinal($model->id);
                    }

                    //$this->redirect(array('clientes/view', 'id' => $model->clienteId));
                }
            } catch (Exception $e) {
                Yii::app()->user->setFlash('error', $e->getMessage());
                print_r($e->getMessage());
                Yii::app()->end();
                //$transaction->rollBack();
            }
        }
        //harcodeada por el tema de las A2 y b2 buscar luego mejor solucion
        
        if ($cliente->cuentaOrden == 1){
            $sucursal=2;
        }else {
            $sucursal=1;
        }

        if ($cliente->condicionIvaId == 1){
            $tipoDocumento="FAC_A";
        }else{
            $tipoDocumento="FAC_B";
        }

        $documento = Documentos::model()->find("tipoDocumento=:tipoDocumento AND sucursal=:sucursal", array(":tipoDocumento" => $tipoDocumento,":sucursal"=>$sucursal) );
        
        
        $this->render('create', array(
            'model' => $model, 'cliente' => $cliente, 'notaVenta' => new NotaVenta, 'documento' => $documento
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

        if (isset($_POST['Facturas'])) {
            $model->attributes = $_POST['Facturas'];
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
        $dataProvider = new CActiveDataProvider('Facturas');
        $this->render('index', array(
            'dataProvider' => $dataProvider,
        ));
    }

    /**
     * Manages all models.
     */
    public function actionAdmin() {
        $model = new Facturas('search');
        $model->unsetAttributes();  // clear any default values
        if (isset($_GET['Facturas']))
            $model->attributes = $_GET['Facturas'];

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
        $model = Facturas::model()->findByPk($id);
        if ($model === null)
            throw new CHttpException(404, 'The requested page does not exist.');
        return $model;
    }

    /**
     * Performs the AJAX validation.
     * @param CModel the model to be validated
     */
    protected function performAjaxValidation($model) {
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'facturas-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }

    public function actionFinal($id) {
        $url=$this->createAbsoluteUrl("facturas/facturaPDF",array("id"=>$id));

        echo '<script type="text/javascript" language="javascript">
		window.open("'.$url.'");
		</script>';
        $model = $this->loadModel($id);
        $cliente=  Clientes::model()->findByPk($model->clienteId);
        /*$this->render('/clientes/view',array(
		'model'=>$cliente,
		));*/
        $this->redirect(array('facturas/admin'));
    }

    public function actionFacturaPDF($id) {
        $model = $this->loadModel($id);
        //$pdf = Yii::createComponent('application.extensions.tcpdf.ETcPdf', 'P', 'cm', 'A4', true, 'UTF-8');

        //Yii::import("application.extensions.fpdf.FDPF");
        Yii::import("application.extensions.PDF");
        //Yii::import("application.extensions.fpdf.FPDI");
        //Yii::import("application.extensions.fpdf.FPDF");

        //inicializacion de coordenadas y variables
        $coordenadaXCantidad=11;
        $coordenadaXDetalle=22;
        $coordenadaXPrecioUnitario=144;
        $coordenadaXMonto=179;

        $altoLineaDetalle=8;

        //coordenada y inicializada en 96
        $y=96;

        $fpdf=new PDF();
        //$pagecount = $fpdf->setSourceFile('F:\maxi\Formato Factura ARLAB.pdf');
         //$tplidx = $fpdf->importPage(1);

        $fpdf->addPage();
        //$fpdf->useTemplate($tplidx);
        $fpdf->SetFont("Courier");
        $fpdf->SetFontSize(11);
        $fpdf->SetXY(148,36);
        $fpdf->Cell(0, 3, $model->fecha, 0, 1, 'L');
        $fpdf->SetXY(35,62);
        $fpdf->Cell(0, 3, utf8_decode($model->cliente->razonSocial), 0, 1, 'L');
        $fpdf->SetXY(146,61);
        $fpdf->Cell(0, 3, $model->cliente->cuit, 0, 1, 'L');
        $fpdf->SetXY(30,74);
        $fpdf->Cell(0, 3, utf8_decode($model->cliente->ciudad->nombre)." ".utf8_decode($model->cliente->direccion), 0, 1, 'L');

        $subtotal=0;

        foreach($model->facturasNotaVenta as $fnv){
            $saldo=$fnv->monto;
            $detalle=$fnv->notaVenta->detalle." - Período: ".$fnv->notaVenta->periodo;

            $fpdf->SetXY($coordenadaXCantidad,$y);
            $fpdf->Cell(0, 3, 1, 0, 1, 'L');

            $fpdf->SetXY($coordenadaXPrecioUnitario,$y);
            $fpdf->Cell(0, 3, "$".number_format($saldo,2), 0, 1, 'L');
            $fpdf->SetXY($coordenadaXMonto,$y);
            $fpdf->Cell(0, 3,"$".number_format($saldo,2), 0, 1, 'L');
            //$detalle=  substr($detalle, 0, 50);

            $fpdf->SetXY($coordenadaXDetalle,$y-2);
            $fpdf->MultiCell(112, 8, utf8_decode($detalle), 0,'FJ',0);
            $y=$fpdf->GetY()+(int)(($fpdf->NbLines(112,$detalle)));
            // if(strlen($detalle)>44){
            //     $detalle_y=$y;

            //     $inicio=0;
            //     $fin=44;
            //     $i=0;
            //     while($i<strlen($detalle)){
            //         $fpdf->SetXY($coordenadaXDetalle,$detalle_y);
            //         $detalle_y+=6;
            //         if(($i+$fin)>strlen($detalle))
            //             $fin=strlen($detalle)-$i;
            //         else
            //             $fin=44;
            //         //$fin=strpos(wordwrap($detalle, 50), "\n",$i);

            //         $deta=substr($detalle, $i, $fin);
            //         $i+=$fin;
            //         $fpdf->Cell(0, 3, $deta."", 1, 1, 'FJ',1);
            //     }
            //     $y=$detalle_y+2;
            // } else {
            //     $fpdf->SetXY($coordenadaXDetalle,$y);
            //     $fpdf->Cell(0, 3, $detalle, 0, 1, 'L');
            //     $y+=$altoLineaDetalle;
            // }
            //$fpdf->Ln();
            //$fpdf->MultiCell(112, 8, $detalle."", 0, 0, 'FJ',0);

            $subtotal+=$saldo;
        }
        if($model->recargo!="" && $model->recargo!=0){
            $fpdf->SetXY($coordenadaXCantidad,$y);
            $fpdf->Cell(0, 3, 1, 0, 1, 'L');
            $fpdf->SetXY($coordenadaXDetalle,$y);
            $fpdf->Cell(0, 3, "Recargo", 0, 1, 'L');
            $fpdf->SetXY($coordenadaXPrecioUnitario,$y);
            $fpdf->Cell(0, 3, "$".number_format($model->recargo,2), 0, 1, 'L');
            $fpdf->SetXY($coordenadaXMonto,$y);
            $fpdf->Cell(0, 3,"$".number_format($model->recargo,2), 0, 1, 'L');
            $y+=8;
            $subtotal+=$model->recargo;
        }

        if($model->descuento!="" && $model->descuento!=0){
            $fpdf->SetXY($coordenadaXCantidad,$y);
            $fpdf->Cell(0, 3, 1, 0, 1, 'L');
            $fpdf->SetXY($coordenadaXDetalle,$y);
            $fpdf->Cell(0, 3, "Descuento", 0, 1, 'L');
            $fpdf->SetXY($coordenadaXPrecioUnitario,$y);
            $fpdf->Cell(0, 3, "-$".number_format($model->descuento,2), 0, 1, 'L');
            $fpdf->SetXY($coordenadaXMonto,$y);
            $fpdf->Cell(0, 3,"-$".number_format($model->descuento,2), 0, 1, 'L');
            $y+=8;
            $subtotal-=$model->descuento;
        }

        $fpdf->SetXY(95,251);
        $fpdf->Cell(0, 3, '$'.  number_format($subtotal,2), 0, 1, 'L');
        $fpdf->SetXY(133,251);
        $fpdf->Cell(0, 3, '$'.  number_format($subtotal*0.21,2), 0, 1, 'L');
        $fpdf->SetXY(172,251);
        $fpdf->Cell(0, 3, '$'.$model->montoTotal, 0, 1, 'L');

        $fpdf->Output($model->tipoFactura.'_'.str_pad(($model->puntoVenta),'4',"0", STR_PAD_LEFT).'-'.str_pad(($model->numero),'9',"0", STR_PAD_LEFT).'.pdf', 'I');

    }

}
