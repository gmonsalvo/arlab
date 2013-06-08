<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->id), array('view', 'id'=>$data->id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('cuentaId')); ?>:</b>
	<?php echo CHtml::encode($data->cuentaId); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('saldoTotal')); ?>:</b>
	<?php echo CHtml::encode($data->saldoTotal); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('valorActualTotal')); ?>:</b>
	<?php echo CHtml::encode($data->valorActualTotal); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('userStamp')); ?>:</b>
	<?php echo CHtml::encode($data->userStamp); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('timeStamp')); ?>:</b>
	<?php echo CHtml::encode($data->timeStamp); ?>
	<br />


</div>