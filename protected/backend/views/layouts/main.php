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
               array('label'=>'Servicios WEB', 'url'=>array('#'),
                  'items'=>array(
                    array('label'=>'Cuenta Corriente','url'=>array('/site/ctacte')),
                    array('label'=>'Pago Electronico','url'=>array('/pagosElectronicos/create')),  
                    array('label'=>'Historial de Pagos','url'=>array('/pagosElectronicos/admin')),  
                  ),
                ),
            
              
    ))); ?>
	</div><!-- mainmenu -->
	<?php endif?>
	<?php if (isset(Yii::app()->user->model)):?>
	<div align="right">
     		<?php
			$this->beginWidget('zii.widgets.CPortlet', array(
				'title'=>'',
			));
		
            
       echo "<b>".Yii::app()->user->model->apynom."</b>  ";
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
		<?php echo Yii::powered(); ?>
	</div><!-- footer -->

</div><!-- page -->

</body>
</html>
