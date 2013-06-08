<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->id), array('view', 'id'=>$data->id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('razonSocial')); ?>:</b>
	<?php echo CHtml::encode($data->razonSocial); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('condicionIvaId')); ?>:</b>
	<?php echo CHtml::encode($data->condicionIvaId); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('direccion')); ?>:</b>
	<?php echo CHtml::encode($data->direccion); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('cuit')); ?>:</b>
	<?php echo CHtml::encode($data->cuit); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('telefono')); ?>:</b>
	<?php echo CHtml::encode($data->telefono); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('interno')); ?>:</b>
	<?php echo CHtml::encode($data->interno); ?>
	<br />

	<?php /*
	<b><?php echo CHtml::encode($data->getAttributeLabel('mail')); ?>:</b>
	<?php echo CHtml::encode($data->mail); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('web')); ?>:</b>
	<?php echo CHtml::encode($data->web); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('infoAdicional')); ?>:</b>
	<?php echo CHtml::encode($data->infoAdicional); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('ciudadId')); ?>:</b>
	<?php echo CHtml::encode($data->ciudadId); ?>
	<br />

	*/ ?>

</div>