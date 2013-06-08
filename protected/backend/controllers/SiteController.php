<?php

class SiteController extends Controller
{
	/**
	 * Declares class-based actions.
	 */
	public function actions()
	{
		return array(
			// captcha action renders the CAPTCHA image displayed on the contact page
			'captcha'=>array(
				'class'=>'CCaptchaAction',
				'backColor'=>0xFFFFFF,
			),
			// page action renders "static" pages stored under 'protected/views/site/pages'
			// They can be accessed via: index.php?r=site/page&view=FileName
			'page'=>array(
				'class'=>'CViewAction',
			),
		);
	}

	/**
	 * This is the default 'index' action that is invoked
	 * when an action is not explicitly requested by users.
	 */
	public function actionIndex()
	{
		if (isset(Yii::app()->user->model)){
			
			// display the login form
			$this->render("index");
		
		}else{
			$model=new LoginForm;

			// if it is ajax validation request
			if(isset($_POST['ajax']) && $_POST['ajax']==='login-form')
			{
				echo CActiveForm::validate($model);
				Yii::app()->end();
			}
	
			// collect user input data
			if(isset($_POST['LoginForm']))
			{
				$model->attributes=$_POST['LoginForm'];
				// validate user input and redirect to the previous page if valid
				if($model->validate() && $model->login())
					$this->redirect(Yii::app()->user->returnUrl);
			}
			// display the login form
			$this->render('login',array('model'=>$model));
		}
	   }
	/**
	 * This is the action to handle external exceptions.
	 */
	public function actionPagar()
	{
	$botonPago="<form action='https://argentina.dineromail.com/Shop/Shop_Ingreso.asp' method='post'>
		<input type='hidden' name='NombreItem' value='Abono Mensual'>
		<input type='hidden' name='TipoMoneda' value='1'>
		<input type='hidden' name='PrecioItem' value='14.20'>
		<input type='hidden' name='E_Comercio' value='34317'>
		<input type='hidden' name='NroItem' value='-'>
		<input type='hidden' name='image_url' value='http://'>
		<input type='hidden' name='DireccionExito' value='http://devel.arlab.com.ar/backend.php/site/exito'>
		<input type='hidden' name='DireccionFracaso' value='http://devel.arlab.com.ar/backend.php/site/fracaso'>
		<input type='hidden' name='DireccionEnvio' value='1'>
		<input type='hidden' name='Mensaje' value='1'>
		<input type='hidden' name='MediosPago' value='4'>
		<input type='image' src='https://argentina.dineromail.com/imagenes/botones/pagar-tarjetas_bn.gif' border='0' name='submit' alt='Pagar con DineroMail'>
		</form>";
		echo $botonPago;
 
	}
	
	public function actionCtaCte()
	{
		$model=new CtaCteClientes('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['CtaCteClientes']))
			$model->attributes=$_GET['CtaCteClientes'];

		$this->render('ctacte',array(
			'model'=>$model,
		));
	
	}

	public function actionPagoElectronico()
	{
		
		$this->render('pagoElectronico');
	
	}

	public function actionExito()
	{
	    echo "Transaccion realizada con exito.<br>Muchas Gracias!";
	}

	public function actionFracaso()
	{
	    echo "Ha ocurrido un Error!";
	}

	public function actionError()
	{
	    if($error=Yii::app()->errorHandler->error)
	    {
	    	if(Yii::app()->request->isAjaxRequest)
	    		echo $error['message'];
	    	else
	        	$this->render('error', $error);
	    }
	}
	/**
	 * Displays the contact page
	 */
	public function actionContact()
	{
		$model=new ContactForm;
		if(isset($_POST['ContactForm']))
		{
			$model->attributes=$_POST['ContactForm'];
			if($model->validate())
			{
				$headers="From: {$model->email}\r\nReply-To: {$model->email}";
				mail(Yii::app()->params['adminEmail'],$model->subject,$model->body,$headers);
				Yii::app()->user->setFlash('contact','Thank you for contacting us. We will respond to you as soon as possible.');
				$this->refresh();
			}
		}
		$this->render('contact',array('model'=>$model));
	}

	/**
	 * Displays the login page
	 */
	public function actionLogin()
	{
		$model=new LoginForm;

		// if it is ajax validation request
		if(isset($_POST['ajax']) && $_POST['ajax']==='login-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}

		// collect user input data
		if(isset($_POST['LoginForm']))
		{
			$model->attributes=$_POST['LoginForm'];
			// validate user input and redirect to the previous page if valid
			if($model->validate() && $model->login())
				$this->redirect(Yii::app()->user->returnUrl);
		}
		// display the login form
		$this->render('login',array('model'=>$model));
	}

	/**
	 * Logs out the current user and redirect to homepage.
	 */
	public function actionLogout()
	{
		Yii::app()->user->logout();
		$this->redirect("login");
	}

	public function actionWebservice()
	{
		
		$this->render("webservice");
	}


}
