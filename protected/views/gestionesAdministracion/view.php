<?php
$this->breadcrumbs=array(
	'Gestiones Administracions'=>array('index'),
	$model->id,
);

$this->menu=array(
	array('label'=>'List GestionesAdministracion', 'url'=>array('index')),
	array('label'=>'Create GestionesAdministracion', 'url'=>array('create')),
	array('label'=>'Update GestionesAdministracion', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Delete GestionesAdministracion', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage GestionesAdministracion', 'url'=>array('admin')),
);
?>

<h1>View GestionesAdministracion #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'clienteId',
		array(
               'label' => 'Tipo Gestion',
               'value' => $model->tipoGestion->nombre),
		'fecha',
		'detalle',
		array(
               'label' => 'Usuario',
               'value' => $model->usuario->username),
	),
)); ?>
