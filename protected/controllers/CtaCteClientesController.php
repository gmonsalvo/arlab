<?php

class CtaCteClientesController extends Controller
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
				'actions'=>array('create','update','admin'),
				'users'=>array('@'),
			),
			array('allow', // allow admin user to perform 'admin' and 'delete' actions
				'actions'=>array('admin','delete'),
				'users'=>array('admin'),
			),
                        array('allow', // allow admin user to perform 'admin' and 'delete' actions
				'actions'=>array('admin','delete','bonificacion'),
				'users'=>array('gmonsalvo','khaure'),
			),
			array('deny',  // deny all users
				'users'=>array('*'),arlab
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
		$model=new CtaCteClientes;

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['CtaCteClientes']))
		{
			$model->attributes=$_POST['CtaCteClientes'];
			if($model->save())
			{
			    Yii::app()->user->setFlash('success','Movimiento creado con exito!');	
				$this->redirect(array('admin','clienteId'=>$model->clienteId));
				}
		}

		$this->render('create',array(
			'model'=>$model,
		));
	}
        
        public function actionBonificacion()
	{
		$model=new CtaCteClientes;

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['CtaCteClientes']))
		{
			
			$model->attributes=$_POST['CtaCteClientes'];
                        $model->userStamp = Yii::app()->user->model->username;
                        $model->timeStamp= Date("Y-m-d h:m:s");
            $notaVenta = NotaVenta::model()->findBypk($model->notaVentaId);
			$saldo=$notaVenta->getSaldo();            
			if($model->save())
			{
			    //si la nota de se cancela con la bonificacion le cambiamos el estado
                           
                            echo "Saldo:".$saldo;
                            echo "Monto a Pagar:".$model->monto;

                            $diferencia=$saldo-$model->monto;
                            echo "diferencia:".$diferencia;
                            if ($diferencia<=0) {
                                $notaVenta->estado = 1;
                            } else {
                                $notaVenta->estado = 0;
                            }
                            $notaVenta->save();

                            Yii::app()->user->setFlash('success','Bonificacion creado con exito!');	
                            $this->redirect(array('admin','clienteId'=>$model->notaVenta->clienteId));
			}
		}

		$this->render('createDescuento',array(
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

		if(isset($_POST['CtaCteClientes']))
		{
			$model->attributes=$_POST['CtaCteClientes'];
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
		$dataProvider=new CActiveDataProvider('CtaCteClientes');
		$this->render('index',array(
			'dataProvider'=>$dataProvider,
		));
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$model=new CtaCteClientes('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['CtaCteClientes']))
			$model->attributes=$_GET['CtaCteClientes'];

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
		$model=CtaCteClientes::model()->findByPk((int)$id);
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
		if(isset($_POST['ajax']) && $_POST['ajax']==='cta-cte-clientes-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
