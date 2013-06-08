<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->id), array('view', 'id'=>$data->id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('fecha')); ?>:</b>
	<?php echo CHtml::encode($data->fecha); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('periodoInicio')); ?>:</b>
	<?php echo CHtml::encode($data->periodoInicio); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('periodoFin')); ?>:</b>
	<?php echo CHtml::encode($data->periodoFin); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('cobradorId')); ?>:</b>
	<?php echo CHtml::encode($data->cobradorId); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('estado')); ?>:</b>
	<?php echo CHtml::encode($data->estado); ?>
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