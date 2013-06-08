<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->id), array('view', 'id'=>$data->id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('arqueoId')); ?>:</b>
	<?php echo CHtml::encode($data->arqueoId); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('tipoFondoId')); ?>:</b>
	<?php echo CHtml::encode($data->tipoFondoId); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('saldo')); ?>:</b>
	<?php echo CHtml::encode($data->saldo); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('valorActual')); ?>:</b>
	<?php echo CHtml::encode($data->valorActual); ?>
	<br />


</div>