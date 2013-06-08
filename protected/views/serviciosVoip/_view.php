<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->id), array('view', 'id'=>$data->id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('fechaInstalacion')); ?>:</b>
	<?php echo CHtml::encode($data->fechaInstalacion); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('domicilio')); ?>:</b>
	<?php echo CHtml::encode($data->domicilio); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('ciudadId')); ?>:</b>
	<?php echo CHtml::encode($data->ciudadId); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('clienteId')); ?>:</b>
	<?php echo CHtml::encode($data->clienteId); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('ciclo')); ?>:</b>
	<?php echo CHtml::encode($data->ciclo); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('costoServicio')); ?>:</b>
	<?php echo CHtml::encode($data->costoServicio); ?>
	<br />

	<?php /*
	<b><?php echo CHtml::encode($data->getAttributeLabel('interno')); ?>:</b>
	<?php echo CHtml::encode($data->interno); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('did')); ?>:</b>
	<?php echo CHtml::encode($data->did); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('sipServer')); ?>:</b>
	<?php echo CHtml::encode($data->sipServer); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('detalleEquipo')); ?>:</b>
	<?php echo CHtml::encode($data->detalleEquipo); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('userStamp')); ?>:</b>
	<?php echo CHtml::encode($data->userStamp); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('timeStamp')); ?>:</b>
	<?php echo CHtml::encode($data->timeStamp); ?>
	<br />

	*/ ?>

</div>