<h1>Historial de Pagos Electronicos</h1>


<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'pagos-electronicos-grid',
	'dataProvider'=>$model->historial(Yii::app()->user->model->username),
	
	'columns'=>array(
		'id',
		'fecha',
		'procesadorPago',
		'monto',
		array(        
		      'name'=>'estado',
		      'header'=>'Estado',
		      'value'=>'($data->estado)==1?"ACREDITADO":"PENDIENTE"',
		   ),
		'fechaAcreditacion',
		
	),
)); ?>
