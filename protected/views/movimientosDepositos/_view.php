<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->id), array('view', 'id'=>$data->id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('depositoId')); ?>:</b>
	<?php echo CHtml::encode($data->depositoId); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('equipoId')); ?>:</b>
	<?php echo CHtml::encode($data->equipoId); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('tipoMov')); ?>:</b>
	<?php echo CHtml::encode($data->tipoMov); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('cantidad')); ?>:</b>
	<?php echo CHtml::encode($data->cantidad); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('observaciones')); ?>:</b>
	<?php echo CHtml::encode($data->observaciones); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('userStamp')); ?>:</b>
	<?php echo CHtml::encode($data->userStamp); ?>
	<br />

	<?php /*
	<b><?php echo CHtml::encode($data->getAttributeLabel('timeStamp')); ?>:</b>
	<?php echo CHtml::encode($data->timeStamp); ?>
	<br />

	*/ ?>

</div>