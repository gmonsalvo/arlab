<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<meta name="language" content="en" />

	<!-- blueprint CSS framework -->
	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/screen.css" media="screen, projection" />
	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/print.css" media="print" />
	<!--[if lt IE 8]>
	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/ie.css" media="screen, projection" />
	<![endif]-->

	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/main.css" />
	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/form.css" />

	<title><?php echo CHtml::encode($this->pageTitle); ?></title>
</head>

<body>

<div class="container" id="page">

	<div id="header">
		<div id="logo"><?php echo CHtml::encode(Yii::app()->name); ?>
	</div><!-- header -->
   
<?php if (isset(Yii::app()->user->model)):?>
	<div id="mainMBMenu">
	<?php 
	//if(Yii::app()->user->isGuest): echo CHtml::beginForm(array('site/login'));
        
        
	$this->widget('application.extensions.mbmenu.MbMenu',array(
            'items'=>array(
                array('label'=>'Home', 'url'=>array('/site/index')),
                array('label'=>'Configuracion', 'url'=>array('#'),
                  'items'=>array(
                    array('label'=>'Provincias','url'=>array('/provincia/admin')),
                    array('label'=>'Ciudades','url'=>array('/ciudades/admin')),
                    array('label'=>'Barrios','url'=>array('/barrios/admin')),  
                    array('label'=>'Condiciones ante el IVA','url'=>array('/condicionesIva/admin')),
                    array('label'=>'Nodos y Servidores','url'=>array('/nodos/admin')),  
                    array('label'=>'Tipos Gestiones','url'=>array('/tiposGestiones/admin')),
                    array('label'=>'Temas de Gestiones','url'=>array('/temasGestion/admin')),        
                    array('label'=>'Monedas','url'=>array('/monedas/admin')),    
                    array('label'=>'Instaladores','url'=>array('/instaladores/admin')),    
                    array('label'=>'Equipos/Productos','url'=>array('/equipos/admin')),    
                    array('label'=>'Planes','url'=>array('/planes/admin')),    
                    
                  ),
                ),
                array('label'=>'Stock', 'url'=>array('#'),
                  'items'=>array(
                    array('label'=>'Movimiento Manual','url'=>array('/movimientosStock/create')),
                    array('label'=>'Movimiento Entre Depositos','url'=>array('/movimientosDepositos/create')),  
                    array('label'=>'Log de Movimientos','url'=>array('/movimientosStock/admin')),
                    array('label'=>'Consulta de Existencias','url'=>array('/movimientosStock/existencias')),  
		    array('label'=>'Depositos','url'=>array('/depositos/admin')),  
                  ),
                ),
                array('label'=>'Clientes', 'url'=>array('clientes/admin'),
                  
                ),
                array('label'=>'Adm y Ventas', 'url'=>array('#'),
                  'items'=>array(
                    
                    array('label'=>'Planificaciones','url'=>array('/eventos/admin')),
		                array('label'=>'Ventas','url'=>array('#')),
                    array('label'=>'Gestiones de Cobranzas','url'=>array('/gestiones/cobranzas')),
                    array('label'=>'Reportes Morosos','url'=>array('/clientes/viewReporteMorosos')),
                    array('label'=>'Registro de Pagos DineroMail','url'=>array('/reportesDineroMail/create')),
                    array('label'=>'Acreditar DineroMail','url'=>array('/dineroMailPagos/admin')),
                    array('label'=>'Rendiciones','url'=>array('/rendiciones/admin')),  

                  ),
                ),
		array('label'=>'Finanzas', 'url'=>array('#'),
                  'items'=>array(
                    array('label'=>'Caja Diaria','url'=>array('/flujoFondos/adminCajaDiaria')),
                    array('label'=>'Caja Mayor','url'=>array('/flujoFondos/adminCajaMayor')),
                    array('label'=>'Cuentas Corriente','url'=>array('#')),
                    array('label'=>'Recibos Emitidos','url'=>array('/recibos/admin')),
                    array('label'=>'Facturas Emitidas','url'=>array('/facturas/admin')),
                    array('label'=>'Reportes x Conceptos','url'=>array('/flujoFondos/reporteConceptos')),
                  ),
                ),
               array('label'=>'Back Office',
                  'items'=>array(
                    array('label'=>'Soporte Tecnicos','url'=>array('/gestiones/soportes')),
                    array('label'=>'Suspensiones/Bajas','url'=>array('/suspensiones/admin')),  
                    array('label'=>'Cambios de Plan','url'=>array('/cambioPlan/admin')),
                    array('label'=>'Busq. Servicios','url'=>array('/serviciosInternet/admin')),
                    array('label'=>'Clientes Suspendidos','url'=>array('/clientes/viewSuspendidos')),
                      
                  ),
                ),
				
            ),
    )); ?>
	</div><!-- mainmenu -->
	<?php endif?>
	<?php if (isset(Yii::app()->user->model)):?>
	<div align="right">
     		<?php
			$this->beginWidget('zii.widgets.CPortlet', array(
				'title'=>'',
			));
		
            
                         echo "<b>Usuario Actual:</b> ".Yii::app()->user->model->username."  ";
                         //echo "Conexion:".Yii::app()->db->connectionString;
			 echo CHtml::link('Cerrar Sesion',array('site/logout')); 
		    $this->endWidget();
     ?>
    </div>
    <?php endif?>
	<?php if(isset($this->breadcrumbs)):?>
		<?php $this->widget('zii.widgets.CBreadcrumbs', array(
			'links'=>$this->breadcrumbs,
		)); ?><!-- breadcrumbs -->
	<?php endif?>
	      <?php $this->widget('Flashes'); ?>
	<?php echo $content;?>

	<div id="footer">
		Copyright &copy; <?php echo date('Y'); ?> by ARLAB TI - Dev Division.<br/>
		Todos los Derechos reservados.<br/>
		<?php 
    $cs=Yii::app()->clientScript;
    $cs->registerScript('submit','
      $(":submit").mouseup(function() {
          $(this).attr("disabled",true);
          $(this).parents("form").submit();
        })',CClientScript::POS_READY);

    echo Yii::powered(); ?>
	</div><!-- footer -->

</div><!-- page -->

</body>
</html>
