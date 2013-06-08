<?php

class FlujoFondosController extends Controller
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
			array('allow', // allow authenticated user to perform 'create' and 'update' actions
				'actions'=>array('adminCajaDiaria','createDiaria','obtenerConceptos'),
				'users'=>array('marroyo'),
			),
			array('allow', // allow admin user to perform 'admin' and 'delete' actions
				'actions'=>array('admin','delete','adminCajaMayor','createMayor','adminCajaDiaria','createDiaria','obtenerConceptos','reporteConceptos'),
				'users'=>array('gmonsalvo','khaure'),
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
	public function actionCreateDiaria()
	{
		$model=new FlujoFondos;

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['FlujoFondos']))
		{
			$model->attributes=$_POST['FlujoFondos'];
			print_r($_POST['FlujoFondos']);
			echo $model->periodo;
			if($model->save()) {
				$ejecutar = '<script type="text/javascript" language="javascript">
				window.open("'.Yii::app()->createUrl("/FlujoFondos/reciboPDF", array("id"=>$model->id)).'");
				</script>';
	        	Yii::app()->session['ejecutar'] = $ejecutar;
    	    	Yii::app()->user->setFlash('success', 'Orden de Pago Procesada con exito');
        		$this->redirect(array('adminCajaDiaria','FlujoFondos[periodo]'=>$model->periodo,'FlujoFondos[cuentaId]'=>$model->cuentaId));
          }
		}

		$this->render('create',array(
			'model'=>$model,'retorno'=>'adminCajaDiaria',
		));
	}

	public function actionCreateMayor()
	{
		$model=new FlujoFondos;

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['FlujoFondos']))
		{
			$model->attributes=$_POST['FlujoFondos'];
			print_r($_POST['FlujoFondos']);
			echo $model->periodo;
			if($model->save()) {
				$ejecutar = '<script type="text/javascript" language="javascript">
				window.open("'.Yii::app()->createUrl("/flujoFondos/reciboPDF", array("id"=>$model->id)).'");
				</script>';
	        	Yii::app()->session['ejecutar'] = $ejecutar;
    	    	Yii::app()->user->setFlash('success', 'Momvimiento registrado con exito');
        		$this->redirect(array('adminCajaMayor','FlujoFondos[periodo]'=>$model->periodo,'FlujoFondos[cuentaId]'=>$model->cuentaId));
            }
		}

		$this->render('create',array(
			'model'=>$model,'retorno'=>'adminCajaMayor',
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

		if(isset($_POST['FlujoFondos']))
		{
			$model->attributes=$_POST['FlujoFondos'];
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
		$dataProvider=new CActiveDataProvider('FlujoFondos');
		$this->render('index',array(
			'dataProvider'=>$dataProvider,
		));
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$model=new FlujoFondos('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['FlujoFondos']))
			$model->attributes=$_GET['FlujoFondos'];

		$this->render('admin',array(
			'model'=>$model,
		));
	}

	/**
	 * Reporte x Conceptos
	 */
	public function actionReporteConceptos()
	{
		$model=new FlujoFondos('searchConceptos');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['FlujoFondos'])) {
			$model->attributes=$_GET['FlujoFondos'];
		  	$model->fechaInicio=date('Y-m-d', CDateTimeParser::parse($_GET['fechaInicio'], 'dd/MM/yyyy'));
            $model->fechaFin=date('Y-m-d', CDateTimeParser::parse($_GET['fechaFin'], 'dd/MM/yyyy'));
		} 	
		$this->render('reporteConceptos',array(
			'model'=>$model,
		));
	}


	public function actionAdminCajaDiaria()
	{
		$model=new FlujoFondos('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['FlujoFondos']))
			$model->attributes=$_GET['FlujoFondos'];

		$this->render('adminCajaDiaria',array(
			'model'=>$model,
		));
	}

	public function actionAdminCajaMayor()
	{
		$model=new FlujoFondos('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['FlujoFondos']))
			$model->attributes=$_GET['FlujoFondos'];

		$this->render('adminCajaMayor',array(
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
		$model=FlujoFondos::model()->findByPk($id);
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
		if(isset($_POST['ajax']) && $_POST['ajax']==='flujo-fondos-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}

	public function actionObtenerConceptos()
	{
    	$data=ConceptosFlujoFondos::model()->findAll('tipoConcepto=:tipoConcepto', 
                  array(':tipoConcepto'=>(int) $_POST['tipoMov']));
 
	    $data=CHtml::listData($data,'id','nombre');
    	foreach($data as $value=>$name)
    	{
        	echo CHtml::tag('option',
            	       array('value'=>$value),CHtml::encode($name),true);
    	}
	}


	public function actionReciboPDF($id) {
        $model = $this->loadModel($id);


        $pdf = Yii::createComponent('application.extensions.tcpdf.ETcPdf', 'P', 'cm', 'A4', true, 'UTF-8');
        $pdf->SetCreator(PDF_CREATOR);
        $pdf->SetAuthor("ARLAB TI");
        $pdf->SetTitle("Recibo");
        $pdf->SetKeywords("TCPDF, PDF, example, test, guide");
        $pdf->setPrintHeader(false);
        $pdf->setPrintFooter(false);
        $pdf->AliasNbPages();
        $pdf->AddPage();
        $pdf->SetFont("times", "B", 12);
        //$pdf->Write(0, $model->fecha, '', 0, 'R', true, 0, false, false, 0);
        $pdf->Cell(0, 3, 'Recibo', 0, 1, 'C');
        $pdf->Ln();

        $html = 'Fecha: ' . Utilities::ViewDateFormat($model->fecha) . '
                       <br/>
                       <br/>
                        Recibi de Gabriel Monsalvo la suma de:
                        $ ' . Utilities::MoneyFormat($model->monto) . ' () 
                       <br/>
                       En Concepto de: '.$model->concepto->nombre.'/'.$model->descripcion.' 
                       <br/>
                       <br/>';
     
        $pdf->writeHTML($html, true, false, true, false, '');
        $pdf->Ln();
        $pdf->writeHTML("---------------------------", true, false, false, false, "R");
        $pdf->writeHTML("Recibi conforme", true, false, false, false, "R");
        $pdf->Output($id . ".pdf", "I");
    }
}
