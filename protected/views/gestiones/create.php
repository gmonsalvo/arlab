<h1>Nuevo
<?php
$mensaje="";
if ($_GET['tipoGestionId']==3)
{
    
 $mensaje=" Soporte Tecnico";   
}

echo $mensaje;
?>


</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>