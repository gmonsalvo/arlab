<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->id), array('view', 'id'=>$data->id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('nombreApellido')); ?>:</b>
	<?php echo CHtml::encode($data->nombreApellido); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('fechaAlta')); ?>:</b>
	<?php echo CHtml::encode($data->fechaAlta); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('sueldoActual')); ?>:</b>
	<?php echo CHtml::encode($data->sueldoActual); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('montoPrestamo')); ?>:</b>
	<?php echo CHtml::encode($data->montoPrestamo); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('userStamp')); ?>:</b>
	<?php echo CHtml::encode($data->userStamp); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('timeStamp')); ?>:</b>
	<?php echo CHtml::encode($data->timeStamp); ?>
	<br />


</div>