<?php

class MovimientosDepositosController extends Controller
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
		$model=new MovimientosDepositos;

		if(isset($_POST['MovimientosDepositos']))
		{
                        $model->attributes=$_POST['MovimientosDepositos'];
			if ($model->validate()){
                          //Instanciamos movimientos de stock  
                           $movimientos =new MovimientosStock;
                           //Movimiento de Salida
                           $movimientos->fecha=$model->fecha;
                           $movimientos->depositoId=$model->depositoOrigen;
                           $movimientos->equipoId=$model->equipoId;
                           $movimientos->tipoMov=1;
                           $movimientos->cantidad=$model->cantidad;
                           $movimientos->observaciones=$model->observaciones;
                           $movimientos->userStamp=Yii::app()->user->model->username;
                           $movimientos->timeStamp=Date("Y-m-d h:m:s");
                                          
                           if ($movimientos->save()){
                            //Movimiento de Salida
                           $movimientos2 =new MovimientosStock;    
                           $movimientos2->fecha=$model->fecha;
                           $movimientos2->depositoId=$model->depositoDestino;
                           $movimientos2->equipoId=$model->equipoId;
                           $movimientos2->tipoMov=0;
                           $movimientos2->cantidad=$model->cantidad;
                           $movimientos2->observaciones=$model->observaciones;
                           $movimientos2->userStamp=Yii::app()->user->model->username;
                           $movimientos2->timeStamp=Date("Y-m-d h:m:s"); 
                           if ($movimientos2->save()){
                               $this->redirect(array('movimientosStock/admin'));
                               
                           }else{
                               echo "Error en la carga del movimiento de salida";
                               print_r($movimientos);
                               yii::app()->end();
                           }
                               
                           }else{
                               echo "Error en la carga del movimiento de Entrada";
                               print_r($movimientos);
                               yii::app()->end();
                           }
                                                                        
                        }
                    
                   }

		$this->render('create',array(
			'model'=>$model,
		));
	}

	

	
}
