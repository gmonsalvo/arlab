<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->id), array('view', 'id'=>$data->id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('fechaPago')); ?>:</b>
	<?php echo CHtml::encode($data->fechaPago); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('monto')); ?>:</b>
	<?php echo CHtml::encode($data->monto); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('montoNeto')); ?>:</b>
	<?php echo CHtml::encode($data->montoNeto); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('numeroTransaccion')); ?>:</b>
	<?php echo CHtml::encode($data->numeroTransaccion); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('clienteId')); ?>:</b>
	<?php echo CHtml::encode($data->clienteId); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('nroPagoElectronico')); ?>:</b>
	<?php echo CHtml::encode($data->nroPagoElectronico); ?>
	<br />

	<?php /*
	<b><?php echo CHtml::encode($data->getAttributeLabel('estado')); ?>:</b>
	<?php echo CHtml::encode($data->estado); ?>
	<br />

	*/ ?>

</div>