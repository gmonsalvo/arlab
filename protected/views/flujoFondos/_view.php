<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->id), array('view', 'id'=>$data->id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('fecha')); ?>:</b>
	<?php echo CHtml::encode($data->fecha); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('cuentaId')); ?>:</b>
	<?php echo CHtml::encode($data->cuentaId); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('tipoMov')); ?>:</b>
	<?php echo CHtml::encode($data->tipoMov); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('monto')); ?>:</b>
	<?php echo CHtml::encode($data->monto); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('conceptoId')); ?>:</b>
	<?php echo CHtml::encode($data->conceptoId); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('tipoFondoId')); ?>:</b>
	<?php echo CHtml::encode($data->tipoFondoId); ?>
	<br />

	<?php /*
	<b><?php echo CHtml::encode($data->getAttributeLabel('descripcion')); ?>:</b>
	<?php echo CHtml::encode($data->descripcion); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('monedaId')); ?>:</b>
	<?php echo CHtml::encode($data->monedaId); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('userStamp')); ?>:</b>
	<?php echo CHtml::encode($data->userStamp); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('timeStamp')); ?>:</b>
	<?php echo CHtml::encode($data->timeStamp); ?>
	<br />

	*/ ?>

</div>