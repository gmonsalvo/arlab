<h1>
<?php
$mensaje="";
if ($_GET['tipoGestionId']==3)
{
    
 $mensaje=" Soporte Tecnico";   
}

echo $mensaje;
?>


</h1>

<?php echo $this->renderPartial('_formHijo', array('model'=>$model)); ?>