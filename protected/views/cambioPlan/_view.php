<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->id), array('view', 'id'=>$data->id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('servicioInternetId')); ?>:</b>
	<?php echo CHtml::encode($data->servicioInternetId); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('fecha')); ?>:</b>
	<?php echo CHtml::encode($data->fecha); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('accion')); ?>:</b>
	<?php echo CHtml::encode($data->accion); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('observaciones')); ?>:</b>
	<?php echo CHtml::encode($data->observaciones); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('planId')); ?>:</b>
	<?php echo CHtml::encode($data->planId); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('costoServicio')); ?>:</b>
	<?php echo CHtml::encode($data->costoServicio); ?>
	<br />

	<?php /*
	<b><?php echo CHtml::encode($data->getAttributeLabel('userStamp')); ?>:</b>
	<?php echo CHtml::encode($data->userStamp); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('timeStamp')); ?>:</b>
	<?php echo CHtml::encode($data->timeStamp); ?>
	<br />

	*/ ?>

</div>