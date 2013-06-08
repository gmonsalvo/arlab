<?php

class MovimientosCuentasFlujoFondosController extends Controller
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
			array('deny',  // deny all users
				'users'=>array('*'),
			),
		);
	}

	
	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionCreate()
	{
		$model=new MovimientosCuentasFlujoFondos;

		if(isset($_POST['MovimientosCuentasFlujoFondos']))
		{
                        $model->attributes=$_POST['MovimientosCuentasFlujoFondos'];
					if ($model->validate()){
	                          //Instanciamos movimientos de stock  
	                           $movimientos =new FlujoFondos;
	                           //Movimiento de Salida
	                           $movimientos->fecha=$model->fecha;
	                           $movimientos->cuentaId=$model->cuentaOrigen;
	                           $movimientos->tipoFondoId=$model->tipoFondoId;
	                           $movimientos->conceptoId=61;
	                           $movimientos->tipoMov=0;
	                           $movimientos->monedaId=1;
	                           $movimientos->monto=$model->monto;
	                           $movimientos->descripcion=$model->descripcion;
	                           $movimientos->userStamp=Yii::app()->user->model->username;
	                           $movimientos->timeStamp=Date("Y-m-d h:m:s");
                               //print_r($movimientos);           
                           if ($movimientos->save()){
                              //Movimiento de Salida
	                           $movimientos2 =new FlujoFondos;
	                           //Movimiento de Salida
	                           $movimientos2->fecha=$model->fecha;
	                           $movimientos2->cuentaId=$model->cuentaDestino;
	                           $movimientos2->tipoFondoId=$model->tipoFondoId;
	                           $movimientos2->conceptoId=58;
	                           $movimientos2->tipoMov=1;
	                           $movimientos2->monedaId=1;
	                           $movimientos2->monto=$model->monto;
	                           $movimientos2->descripcion=$model->descripcion;
	                           $movimientos2->userStamp=Yii::app()->user->model->username;
	                           $movimientos2->timeStamp=Date("Y-m-d h:m:s");
	                           //echo"-----------------<br>";
	                           //print_r($movimientos2);           
                           if ($movimientos2->save()){
                               $this->redirect(array('FlujoFondos/adminCajaDiaria'));
                               //echo "<br>REDIRECT";
                           }else{
                               echo "Error en la carga del pase de fondos en el moviemnto de Ingreso";
                               
                               print_r($movimientos2);
                               yii::app()->end();
                           }
                               
                           }else{
                                echo "Error en la carga del pase de fondos en el moviemnto de Egreso";
                               print_r($movimientos);
                               yii::app()->end();
                           }
                                                                        
                        } // fin del validate
                    
                   }

		$this->render('create',array(
			'model'=>$model,
		));
	}

	

	
}
