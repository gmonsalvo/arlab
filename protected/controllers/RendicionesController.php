<?php

class RendicionesController extends Controller
{
	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	public $layout='//layouts/column2';

	/**
	 * @return array action filters
	 */
	public function filters()
	{
		return array(
			'accessControl', // perform access control for CRUD operations
		);
	}

	/**
	 * Specifies the access control rules.
	 * This method is used by the 'accessControl' filter.
	 * @return array access control rules
	 */
	public function accessRules()
	{
		return array(
			array('allow',  // allow all users to perform 'index' and 'view' actions
				'actions'=>array('index','view'),
				'users'=>array('*'),
			),
			array('allow', // allow authenticated user to perform 'create' and 'update' actions
				'actions'=>array('create','update','reciboMasivoPdf','admin','finalizar'),
				'users'=>array('@'),
			),
			array('allow', // allow admin user to perform 'admin' and 'delete' actions
				'actions'=>array('admin','delete'),
				'users'=>array('admin'),
			),
			array('deny',  // deny all users
				'users'=>array('*'),
			),
		);
	}

	/**
	 * Displays a particular model.
	 * @param integer $id the ID of the model to be displayed
	 */
	public function actionView($id)
	{
		$this->render('view',array(
			'model'=>$this->loadModel($id),
		));
	}

	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionCreate()
	{
		$model=new Rendiciones;

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);


		if(isset($_POST['Rendiciones']))
		{
		$transaction = $model->dbConnection->beginTransaction();
        try {
			$model->attributes=$_POST['Rendiciones'];
			$model->timeStamp = Date("Y-m-d h:m:s");
            $model->userStamp = Yii::app()->user->model->username;
            $fechaVencimiento = Date("")."-10";
			$model->estado=0;
			if($model->save()){
				//generamos los recibos
				//primero obtenemos todos los clientes de ese cobrador
				$clientes= new Clientes;
				$i=0;
				foreach (Clientes::model()->findAll("cobradorId=".$model->cobradorId.' AND estado=0') as $cliente) {

				  //por cada cliente generamos un recibo
					if ($cliente->getSaldo()>0) { //si el cliente tiene saldo
						//echo $i."-".$cliente->razonSocial.", Saldo:".$cliente->getSaldo()."</br>";
						$recibo=new Recibos();
						$ultimo = $recibo->getUltimoNumero("2");
                 		//actualizamos el numero de recibo en la tabla documentos
                		$sql = "update documentos set ultimoNumero='" . ($ultimo+1). "' where tipoDocumento='REC' and sucursal=2";
                		$result = Yii::app()->db->createCommand($sql)->execute();
                		//seteamos el estado de finalizado en el recibo
                		$recibo->fecha=Date('Y-m-d');
                		$recibo->clienteId=$cliente->id;
                		$recibo->sucursal='2';
                		$recibo->numero=$ultimo;
                		$recibo->userStamp=Yii::app()->user->model->username;
                		$recibo->timeStamp=date("Y-m-d h:m:s");
                		$recibo->montoTotal=0;
                		$recibo->estado = 0;
                		if ($recibo->save()){
							//agregamos los saldos
							$criteria=new CDbCriteria;
							$criteria->addCondition('clienteId='.$cliente->id);
							$criteria->addCondition('estado=0');
							$criteria->addBetweenCondition('periodo', $model->periodoInicio, $model->periodoFin);
							$montoTotalRecibo=0;
        					$saldos=NotaVenta::model()->findAll($criteria);
        					foreach ($saldos as $saldo) {
	        					//llenamos la relacional y sumamos el monto del recibo

	        					$rnv=new RecibosNotaVenta();
	        					$rnv->reciboId=$recibo->id;
	        					$rnv->notaVentaId=$saldo->id;
	        					$rnv->monto=$saldo->getSaldo();
	        					$montoTotalRecibo+=$saldo->getSaldo();
	        					if (!($rnv->save())){
	        						$error = 'Error al guardar el RNV:' . $rnv->getErrors();
                    		  		throw new Exception($error);
	        					}

        					}

							//agregamos un pago
        					$fpr=new FormaPagoRecibos();
        					$fpr->reciboId=$recibo->id;
        					$fpr->fecha=Date('d/m/Y');
        					$fpr->tipoFormaPago=1;
        					$fpr->monto=$montoTotalRecibo;
        					if (!($fpr->save())){
	        						$error = 'Error al guardar el FPR:' . $fpr->getErrors();
                    		  		throw new Exception($error);
	        					}
        					//actualizamos el monto del recibo
        					$recibo->montoTotal=$montoTotalRecibo;

        					if (!($recibo->save())){
	        						$error = 'Error al actualizar el monto del recibo:' . $recibo->getErrors();
                    		  		throw new Exception($error);
	        					}
							// llenamos la relacion con rendicion
							$rr=new RendicionesRecibos();
							$rr->rendicionId=$model->id;
							$rr->reciboId=$recibo->id;
							if (!($rr->save())){
	        						$error = 'Error al guardar el RR:' . $rr->getErrors();
	        						echo "ERROR:".$rr->getErrors()."<br>";
                    		  		throw new Exception($error);
	        					}

        				}//if save recibo
        				else{
        					  $error = 'Error al guardar el recibo:' . $recibo->getErrors();
        					  echo "ERROR:".print_r($recibo->getErrors())."<br>";
                    		  throw new Exception($error);
        				}
					}
				$i++;
				} // fin del for de recorrido de cliente
				//con todos los recibos generados en la base de datos generamos un  solo PDF
				$transaction->commit();
				$this->actionReciboMasivoPdf($model->id);

			}

		}//try
		catch (Exception $e) {
            echo(var_dump($e));
            $transaction->rollBack();
            Yii::app()->end();
        }
		}

		$this->render('create',array(
			'model'=>$model,
		));
	}

	/**
	 * Updates a particular model.
	 * If update is successful, the browser will be redirected to the 'view' page.
	 * @param integer $id the ID of the model to be updated
	 */
	public function actionUpdate($id)
	{
		$model=$this->loadModel($id);

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['Rendiciones']))
		{
			$model->attributes=$_POST['Rendiciones'];
			if($model->save())
				$this->redirect(array('view','id'=>$model->id));
		}

		$this->render('update',array(
			'model'=>$model,
		));
	}

	/**
	 * Deletes a particular model.
	 * If deletion is successful, the browser will be redirected to the 'admin' page.
	 * @param integer $id the ID of the model to be deleted
	 */
	public function actionDelete($id)
	{
		if(Yii::app()->request->isPostRequest)
		{
			// we only allow deletion via POST request
			$this->loadModel($id)->delete();

			// if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
			if(!isset($_GET['ajax']))
				$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
		}
		else
			throw new CHttpException(400,'Invalid request. Please do not repeat this request again.');
	}

	/**
	 * Lists all models.
	 */
	public function actionIndex()
	{
		$dataProvider=new CActiveDataProvider('Rendiciones');
		$this->render('index',array(
			'dataProvider'=>$dataProvider,
		));
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$model=new Rendiciones('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['Rendiciones']))
			$model->attributes=$_GET['Rendiciones'];

		$this->render('admin',array(
			'model'=>$model,
		));
	}


    public function actionReciboMasivoPdf($id) {
        $pdf = Yii::createComponent('application.extensions.tcpdf.ETcPdf', 'P', 'cm', 'A4', true, 'UTF-8');
        $pdf->SetCreator(PDF_CREATOR);
        $pdf->SetAuthor("ARLAB TI");
        $pdf->SetKeywords("TCPDF, PDF, example, test, guide");
        $pdf->setPrintHeader(false);
        $pdf->setPrintFooter(false);
        $pdf->AliasNbPages();

    	//obtenemos todos los recibos para la rendicion

        $rendicion = $this->loadModel($id);
        $recibos=$rendicion->recibos;


        foreach ($recibos as $recibo) {


        $pdf->AddPage();
        $pdf->SetFont("courier", "b", 12);
        //$pdf->Write(0, $model->fecha, '', 0, 'R', true, 0, false, false, 0);
        $pdf->Cell(0, 0.5, 'Recibo', 0, 1, 'C');
        $pdf->Ln();

        $html = 'Fecha: ' . $recibo->fecha . '
                       <br/>
                       Recibo Nro: ' . str_pad($recibo->sucursal, 4, "0", STR_PAD_LEFT) . "-" . str_pad($recibo->numero, 7, "0", STR_PAD_LEFT) . '
                       <br/>
                       Cliente: ' . $recibo->cliente->razonSocial . '
                       <br/>
                       Domicilio ' . $recibo->cliente->direccion .' - '.$recibo->cliente->ciudad->nombre .'
                       <br/>

                       Saldos Pendientes
                       <br/>
                       <br/>
                        ';
        if (count($recibo->RecibosNotaVenta) > 0) {
            $pdf->SetFont("courier", "b", 12);
            $html.= '<table><tr><td>Periodo</td><td colspan=3>Detalle</td><td>Monto</td></tr>';
            $pdf->SetFont("courier", 12);
            foreach ($recibo->RecibosNotaVenta as $nv) {
                $html.="<tr><td>" . $nv->NotaVenta->periodo . "</td><td colspan=3>" . $nv->NotaVenta->detalle . "</td><td>" . Utilities::MoneyFormat($nv->monto) . "</td></tr>";
            }
        }$pdf->SetFont("courier", "b", 12);
        $html.='

              <br/>
              Forma de Pago
              <br/>
            ';

        if (count($recibo->formaPago) > 0) {
            $html.= '<table><tr><td>Fecha</td><td>Tipo Forma Pago</td><td>Referencia</td><td>Monto</td></tr>';
            $pdf->SetFont("courier", 12);
            foreach ($recibo->formaPago as $fp) {
                $html.="<tr><td>" . $fp->fecha . "</td><td>" . $fp->DescripcionFormaPago->nombre . "</td><td>" . $fp->numeroReferencia . "</td><td>" . Utilities::MoneyFormat($fp->monto) . "</td></tr>";
            }
        }
        $html.='   <br/>
                       <br/>
                       Monto Total: ' . Utilities::MoneyFormat($recibo->montoTotal);


        $html.='</tbody></table>';

      	$pdf->writeHTML($html, true, false, true, false, '');
        $pdf->Cell(0, 5.4, '', 0, 1, 'C');
        //$pdf->SetXY(80,5);
        $pdf->SetFont("courier", "b", 12);
        $pdf->Cell(0, 1, 'Recibo', 0, 1, 'C');
        $pdf->SetFont("courier", 12);

        $pdf->writeHTML($html, true, false, true, false, '');

		//echo $html;

    	} // fin del for donde recorremos todos los recibos
    	 $pdf->Output($id . ".pdf", "I");
    }

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer the ID of the model to be loaded
	 */
	public function loadModel($id)
	{
		$model=Rendiciones::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param CModel the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='rendiciones-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}

	public function actionFinalizar($id){
		//$model=new Rendiciones('search');
		if(isset($_POST["total"])){
			$model=$this->loadModel($id);
			$transaction = $model->dbConnection->beginTransaction();
        	try {
				$recibosNoPagados = array();
				foreach ($_POST["montoPagado"] as $reciboId => $monto) {
					set_time_limit(30);
					$recibo = Recibos::model()->findByPk($reciboId);
					if($monto!=0){
					    //insertamos en la cajaDiaria
					    ##sabemos que hay una sola forma de pago por eso el indice 0 en el array
					    $pago = $recibo->formaPago[0];
                        $flujoFondos= new FlujoFondos();
                        $flujoFondos->fecha=date("Y-m-d");
                        $flujoFondos->cuentaId=Yii::app()->params['cuentaCajaDiaria'];
                        $flujoFondos->tipoMov=1; //ingreso
                        $flujoFondos->monto=$monto;
                        $flujoFondos->conceptoId=7; //pagos por abonos
                        $flujoFondos->tipoFondoId=$pago->tipoFormaPago;
                        $flujoFondos->descripcion="Cliente:".$recibo->cliente->razonSocial."  Referencia: ".$pago->numeroReferencia." | <a  target=new  href='/arlab/index.php/recibos/ReciboPDF/".$reciboId."'> Recibo</a>";
                        $flujoFondos->monedaId=1; //pesos
                        $flujoFondos->userStamp=Yii::app()->user->model->username;
                        $flujoFondos->timeStamp= Date("Y-m-d h:m:s");

                        $pago->monto=$monto;
                        if(!$pago->save()){
                        	$error = 'Error al Registrar el Pago:' . $pago->getErrors();
                            throw new Exception($error);
                        }
                        $recibo->montoTotal=$monto;
                        $recibo->estado = 1;
                        if(!$recibo->save()){
                        	$error = 'Error al Actualizar el recibo:' . $recibo->getErrors();
                            throw new Exception($error);
                        }
                        if (!($flujoFondos->save())){
                            $error = 'Error al Registrar el Flujo de Fondos:' . $model->getErrors();
                            throw new Exception($error);
                        }
                        $tmpMonto=$monto;
                        foreach($recibo->RecibosNotaVenta as $reciboNotaVenta){
                        	$ctacte = new CtaCteClientes();
	                        $ctacte->tipoMov = 1; //credito
	                        $ctacte->notaVentaId = $reciboNotaVenta->notaVentaId;
	                        $ctacte->fecha = date("Y-m-d");
	                        $ctacte->conceptoId = 10;
	                        $ctacte->userStamp = Yii::app()->user->model->username;
                            $ctacte->timeStamp = Date("Y-m-d h:m:s");
	                        	                        //antes del recargo si con lo que paga cancelamos la nota de venta
	                        //ponemos el estado correspondiente
	                        $notaVenta = $reciboNotaVenta->NotaVenta;
	                        $diferencia=$notaVenta->getSaldo()-$tmpMonto;
	                        if ($diferencia<=0) {
	                            $notaVenta->estado = NotaVenta::ESTADO_PAGADO;
	                            $ctacte->monto = $reciboNotaVenta->monto;
	                            $tmpMonto-=$reciboNotaVenta->monto;
	                        } else {
	                            $notaVenta->estado = NotaVenta::ESTADO_IMPAGO;
	                            $ctacte->monto = $tmpMonto;
	                            $tmpMonto-=$tmpMonto;
	                        }

	                        if (!$notaVenta->save()) {
	                            $error = 'Error al Guardar la nota de Venta:' . $notaVenta->getErrors();
	                            throw new Exception($error);
	                        }
	                       	if (!$ctacte->save()) {
	                            $error = 'Error al Guardar la en la Cta Cte:' . var_dump($ctacte->getErrors());
	                            throw new Exception($error);
	                        }

                        	if($tmpMonto==0){
                        		break;
                        	}
                        }
                        //
					} else {
						foreach($recibo->RecibosNotaVenta as $reciboNotaVenta){
							##Si no tiene recargo inserto en ctacte
							if(!$reciboNotaVenta->NotaVenta->tieneRecargo()){
								#//debito
	                            $ctacteRd = new CtaCteClientes();
	                            $ctacteRd->tipoMov = 0;
	                            $ctacteRd->notaVentaId = $reciboNotaVenta->notaVentaId;
	                            $ctacteRd->fecha = date("Y-m-d");
	                            $ctacteRd->conceptoId = 14;
	                            $ctacteRd->monto = NotaVenta::RECARGO_FIJO;
	                            $ctacteRd->userStamp = Yii::app()->user->model->username;
	                            $ctacteRd->timeStamp = Date("Y-m-d h:m:s");
	                            if (!$ctacteRd->save()) {
	                                $error = 'Error al Guardar El credito por REcargo en Ctacte:' . $ctacteRd->getErrors();
	                                throw new Exception($error);

	                            }
	                            break;
	                        }
                        }
					}
				} ## end foreach
				$model->estado = Rendiciones::ESTADO_CERRADO;
				$model->save();
				$transaction->commit();
				$this->redirect(array("admin"));
			} catch (Exception $e){
	            echo(var_dump($e->getMessage()));
	            $transaction->rollBack();
	            Yii::app()->end();
			}
		} else {
			$model=$this->loadModel($id);
			//$model->unsetAttributes();  // clear any default values
			// if(isset($_GET['Rendiciones']))
			// 	$model->attributes=$_GET['Rendiciones'];

			$this->render('finalizar',array(
				'model'=>$model,
			));
		}
	}
}
