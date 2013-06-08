<h1>
<?php
$mensaje="";
if ($_GET['tipoGestionId']==3)
{
    
 $mensaje=" Soporte Tecnico";   
}

echo "Cierre de Gestion".$mensaje;
?>


</h1>

<?php echo $this->renderPartial('_cerrar', array('model'=>$model)); ?>