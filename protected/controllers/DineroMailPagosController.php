<?php

class DineroMailPagosController extends Controller
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
				'actions'=>array('delete','admin','acreditar'),
				'users'=>array('khaure','gmonsalvo'),
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
		$model=new DineroMailPagos;

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['DineroMailPagos']))
		{
			$model->attributes=$_POST['DineroMailPagos'];
			if($model->save())
				$this->redirect(array('view','id'=>$model->id));
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

		if(isset($_POST['DineroMailPagos']))
		{
			$model->attributes=$_POST['DineroMailPagos'];
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
		$dataProvider=new CActiveDataProvider('DineroMailPagos');
		$this->render('index',array(
			'dataProvider'=>$dataProvider,
		));
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$model=new DineroMailPagos('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['DineroMailPagos']))
			$model->attributes=$_GET['DineroMailPagos'];

		$this->render('admin',array(
			'model'=>$model,
		));
	}

	public function actionAcreditar($id)
	{
		//cargamos la informacion del pago
		$pago=$this->loadModel($id);
		//generamos el recibo
		$recibo = new Recibos;
        $recibo->clienteId= $pago->clienteId;
        $recibo->fecha=Date('Y-m-d');
        $recibo->montoTotal=0.00;
        $recibo->save();
		//insertamos el pago en el recibo
        $fpr = new FormaPagoRecibos;
        $fpr->reciboId=$recibo->id;
        $fpr->fecha=date('d/m/Y',strtotime($pago->fechaPago));
        $fpr->tipoFormaPago=5;
        $fpr->monto=$pago->monto;
        $fpr->numeroReferencia=$pago->lugarPago." - ".$pago->numeroTransaccion;
        if (!($fpr->save())){
        	echo "Error al Guardar<br>";
        	print_r($fpr->getErrors());
        	exit;
        }
        //actualizamos el estado el pago
        $pago->estado=1;
        $pago->save();
		//lo mandamos al update del recibo
		$this->redirect(array('recibos/update','id'=>$recibo->id));

	}
	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer the ID of the model to be loaded
	 */
	public function loadModel($id)
	{
		$model=DineroMailPagos::model()->findByPk($id);
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
		if(isset($_POST['ajax']) && $_POST['ajax']==='dinero-mail-pagos-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
