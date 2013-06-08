<div class="view">
        
        <b><?php echo CHtml::encode($data->getAttributeLabel('fecha')); ?>:</b>
	<?php echo CHtml::encode($data->fecha); ?>
	<br />
       <br />
	<b><?php echo CHtml::encode($data->getAttributeLabel('temaId')); ?>:
	<?php echo CHtml::encode($data->tema->descripcion); ?></b>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('detalle')); ?>:</b>
	<?php echo CHtml::encode($data->detalle); ?>
	<br />

	

	<b><?php echo CHtml::encode($data->getAttributeLabel('usuarioResponsable')); ?>:</b>
	<?php echo CHtml::encode($data->usuario->username); ?>
	<br />

	

</div>