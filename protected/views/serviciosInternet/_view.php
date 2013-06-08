<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->id), array('view', 'id'=>$data->id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('domicilio')); ?>:</b>
	<?php echo CHtml::encode($data->domicilio); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('ciudadId')); ?>:</b>
	<?php echo CHtml::encode($data->ciudadId); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('telefono')); ?>:</b>
	<?php echo CHtml::encode($data->telefono); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('fecha_instalacion')); ?>:</b>
	<?php echo CHtml::encode($data->fecha_instalacion); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('servidorId')); ?>:</b>
	<?php echo CHtml::encode($data->servidorId); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('repetidorId')); ?>:</b>
	<?php echo CHtml::encode($data->repetidorId); ?>
	<br />

	<?php /*
	<b><?php echo CHtml::encode($data->getAttributeLabel('nivel_senal')); ?>:</b>
	<?php echo CHtml::encode($data->nivel_senal); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('ip_lan')); ?>:</b>
	<?php echo CHtml::encode($data->ip_lan); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('ip_antena')); ?>:</b>
	<?php echo CHtml::encode($data->ip_antena); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('equipoId')); ?>:</b>
	<?php echo CHtml::encode($data->equipoId); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('cicloId')); ?>:</b>
	<?php echo CHtml::encode($data->cicloId); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('clienteId')); ?>:</b>
	<?php echo CHtml::encode($data->clienteId); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('costoServicio')); ?>:</b>
	<?php echo CHtml::encode($data->costoServicio); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('PlanId')); ?>:</b>
	<?php echo CHtml::encode($data->PlanId); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('BarrioId')); ?>:</b>
	<?php echo CHtml::encode($data->BarrioId); ?>
	<br />

	*/ ?>

</div>