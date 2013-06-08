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
				$headers  ="From: {$model->email}\r\nReply-To: {$model->email}";
				
				mail(Yii::app()->params['adminEmail'],$model->subject,$model->body,$headers);
				Yii::app()->user->setFlash('contact','Thank you for contacting us. We will respond to you as soon as possible.');
				$this->refresh();
			}
		}
		$this->render('contact',array('model'=>$model));
	}

	public function actionTestEmail()
	{
		$headers="From: {noreply.arlab@gmail.com\r\nReply-To: {noreply.arlab@gmail.com}";
		$headers .= "MIME-Version: 1.0\r\n";
    	$headers .= "Content-type: text/html; charset=iso-8859-1\r\n";
		mail("gabriel.monsalvo@gmail.com;khaure@gmail.com","Aviso de Vencimiento","Estimado Cliente, le informamos que su cuenta posee saldo por vencer en los proximos dias, su saldo actual es: $560,00<br>Evite la suspension del servicio.<br> Si abono por operatoria bancaria no olvide informar su pago.<br>Mucha Gracias.",$headers);
		
	}

	/**
	 * Displays the login page
	 */

	public function actionMail()
	{
		
		$mail = Yii::createComponent('application.extensions.mailer.EMailer');
		
	    $mail->IsSMTP(); // Using SMTP.
	    $mail->CharSet = 'utf-8';
	    $mail->SMTPDebug = 2; // Enables SMTP debug information - SHOULD NOT be active on production servers!
	    //$mail->SMTPSecure = 'tls';
	    $mail->SMTPAuth = true; // Enables SMTP authentication.
	    $mail->Host = "mail.arlab.com.ar"; // SMTP server host.
	    $mail->Port = 25; // Setting the SMTP port for the GMAIL server.
	    $mail->Username = "karina@arlab.com.ar"; // SMTP account username (GMail email address).
	    $mail->Password = "Arlab1234"; // SMTP account password.
	    $mail->AddReplyTo('karina@arlab.com.ar', 'Notificaciones ARLAB'); // Use this to avoid emails being classified as spam - SHOULD match the GMail email!
	    $mail->AddAddress('khaure@gmail.com', 'Karina'); // Recipient email / name.
	    $mail->SetFrom('karina@arlab.com.ar', 'Notificaciones ARLAB'); // Sender - SHOULD match the GMail email.
	    $mail->Subject = 'Aviso de Mora';
	    //obtenemos la lista de clientes habilitados
	    $clientes=Clientes::model()->getActivos();
	    foreach ($clientes as $cliente) {
	    	if ($cliente->getSaldo()>0) {
		    	echo $cliente->razonSocial.": <br>";
		    	$message = 'Segun nuestro registro posee saldo vencido de: '.$cliente->getSaldo().'<br>';
		    	$message+= 'Contactese a nuestras oficinas a fin de regularizar su situacion.<br>Muchas Gracias';
			    $mail->AltBody = 'To view the message, please use an HTML compatible email viewer!';
			    $mail->MsgHTML($message);
			    echo $message."<br>";
			  }  
	    	//$mail->Send();
	
	    }
	    
	}
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

	public function actionActivar()
	{
		$ip=$_GET['ip'];
		$API = new RouterOS();
		$API->debug = false;

		if ($API->connect('10.100.1.4', 'admin', 'java0801fe@r')) {
		   $API->write("/ip/firewall/address-list/getall",false);
		   $API->write("?list=payment_reminder",false);
		   $API->write("?address=".$ip,false);
		   $API->write("=.proplist=.id");
		   $READ = $API->read();
		   if (count($READ) > 0)
		   {
		   	foreach   ($READ as $item) {
		         
		           $id=$item['.id'];
		           $API->write("/ip/firewall/address-list/remove",false);
		           $result=$API->write("=.id=".$id,true);
		           $READ = $API->read();
		           echo $READ;
		           echo $result;
		           

		   }
		 
		}
	$API->disconnect();	
	} // if connect

	}

	public function actionLog()
	{
		$device=$_GET['device'];
		$voltajeBateria=$_GET['voltajeBateria'];
		$log = new Monitoreo();
		$log->device=$device;
		$log->voltajeBateria=$voltajeBateria;
		//$log->fecha= Date("Y-m-d h:m:s");
		if ($log->save()){
			echo "exito";

		}else{

			echo "Error";
		}

	}


	public function actionSuspender()
	{
		$ip=$_GET['ip'];
		$API = new RouterOS();
		$API->debug = false;

		if ($API->connect('10.100.1.4', 'admin', 'java0801fe@r')) {
		  $API->write('/ip/firewall/address-list/add',false);
          $API->write('=address='.$ip,false);
          $API->write('=list=payment_reminder',true);

		   $READ = $API->read();
		   print_r($READ);
		   $API->disconnect();	
	} // if connect

	}



}
