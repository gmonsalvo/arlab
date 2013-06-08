<?php
$this->breadcrumbs=array(
	'Arqueoses'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List Arqueos', 'url'=>array('index')),
	array('label'=>'Manage Arqueos', 'url'=>array('admin')),
);
?>

<h1>Create Arqueos</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>