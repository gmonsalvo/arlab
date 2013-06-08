<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->id), array('view', 'id'=>$data->id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('nombre')); ?>:</b>
	<?php echo CHtml::encode($data->nombre); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('ip_wan')); ?>:</b>
	<?php echo CHtml::encode($data->ip_wan); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('ssid')); ?>:</b>
	<?php echo CHtml::encode($data->ssid); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('frequencia')); ?>:</b>
	<?php echo CHtml::encode($data->frequencia); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('ip_lan')); ?>:</b>
	<?php echo CHtml::encode($data->ip_lan); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('tipo')); ?>:</b>
	<?php echo CHtml::encode($data->tipo); ?>
	<br />


</div>