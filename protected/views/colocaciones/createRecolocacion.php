

<?php
$this->beginWidget('zii.widgets.CPortlet', array(
				'title'=>'',
			));
			 echo "<h2><b>Nueva Colocacion</b></h2>";
		    $this->endWidget();
?>

<?php echo $this->renderPartial('_Recolocacionesform', array('model'=>$model,'cheques'=>$cheques,'clientes'=>$clientes)); ?>