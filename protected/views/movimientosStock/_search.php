<div class="wide form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'post',
));
?>

<div class="search-button">
	<?php echo CHtml::activeDropDownList($model,'depositoId',
		CHtml::listData(Depositos::model()->findAll(), 
		'id', 'descripcion'),array('empty'=>'Seleccione un Deposito','submit'=>''));
	?>
	
</div>

<?php $this->endWidget(); 
?>

</div><!-- search-form -->