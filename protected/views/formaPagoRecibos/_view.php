<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->id), array('view', 'id'=>$data->id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('reciboId')); ?>:</b>
	<?php echo CHtml::encode($data->reciboId); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('fecha')); ?>:</b>
	<?php echo CHtml::encode($data->fecha); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('tipoFormaPago')); ?>:</b>
	<?php echo CHtml::encode($data->tipoFormaPago); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('numeroReferencia')); ?>:</b>
	<?php echo CHtml::encode($data->numeroReferencia); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('monto')); ?>:</b>
	<?php echo CHtml::encode($data->monto); ?>
	<br />


</div>