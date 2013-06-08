<?php

class ReportesDineroMailController extends Controller
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
				'actions'=>array('create','update'),
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
		$model=new ReportesDineroMail;

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['ReportesDineroMail']))
		{
			$model->attributes=$_POST['ReportesDineroMail'];
			//antes de guardar obtenemos el XML
			$XML='https://argentina.dineromail.com/vender/ConsultaPago.asp?Email='.yii::app()->params['dineroMailId'].'&Acount='.yii::app()->params['dineroMailAccount'].'&Pin='.yii::app()->params['dineroMailPin'].'&StartDate='.$model->fechaInicio.'&EndDate='.$model->fechaFin.'&XML=1';
			$reporte = simplexml_load_file($XML);
			
			echo "Cant. de Registros:".count($reporte->Collections->Collection)."<br>";
			foreach($reporte->Collections->Collection as $c){
			//primero revisamos si esta transaccion ya no fue procesada
			if (count(DineroMailPagos::model()->findAll("numeroTransaccion=".$c->Trx_Number))==0){
				$pago= new DineroMailPagos();
				$pago->nroPagoElectronico=$c->attributes()->Trx_id;	
				$pago->fechaPago=$c->Trx_Date;
				$pago->monto=$c->Trx_Payment;
				$pago->montoNeto=$c->Trx_MontoNeto;
				$pago->numeroTransaccion=$c->Trx_Number;
				$pago->lugarPago=$c->Trx_PaymentMean;
				//tenemos que relazionar el cliente
				$criteria = new CDbCriteria;
    			$criteria->compare('codigoPagoElectronico', $pago->nroPagoElectronico,true);
				$cliente=Clientes::model()->find($criteria);
				
				if ($cliente){
				 $pago->clienteId=$cliente->id; 	
				}else{
				 $pago->clienteId=1;	
				}

				if (!($pago->save())){
					echo "Error al Guardar el pago<br>";
					print_r($pago->getErrors());
					echo "<br>";
				}
			 } 

			} //fin del for
			$model->estado=1;

			if($model->save())
				//echo "Fin.<br>";
				$this->redirect(array('dineroMailPagos/admin'));
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

		if(isset($_POST['ReportesDineroMail']))
		{
			$model->attributes=$_POST['ReportesDineroMail'];
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
		$dataProvider=new CActiveDataProvider('ReportesDineroMail');
		$this->render('index',array(
			'dataProvider'=>$dataProvider,
		));
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$model=new ReportesDineroMail('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['ReportesDineroMail']))
			$model->attributes=$_GET['ReportesDineroMail'];

		$this->render('admin',array(
			'model'=>$model,
		));
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer the ID of the model to be loaded
	 */
	public function loadModel($id)
	{
		$model=ReportesDineroMail::model()->findByPk($id);
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
		if(isset($_POST['ajax']) && $_POST['ajax']==='reportes-dinero-mail-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
