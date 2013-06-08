<script>
    var tipoDocumento ='<?php echo $documento->tipoDocumento?>';
$(document).ready(function() {
 
    $(".numeric").keydown(function(event) {
 
        if (event.keyCode == 46 || event.keyCode == 190 || event.keyCode == 110 || event.keyCode == 8 || event.keyCode == 9 || event.keyCode == 27 || event.keyCode == 13 || (event.keyCode == 65 && event.ctrlKey === true) || (event.keyCode >= 35 && event.keyCode <= 39)) {
            return;
        }
        else {
            // Ensure that it is a number and stop the keypress
            if (event.shiftKey || (event.keyCode < 48 || event.keyCode > 57) && (event.keyCode < 96 || event.keyCode > 105)) {
                event.preventDefault();
            }
        }
    });
 
});

    function CalcularMontoTotal(id){
        //si hay alguno seleccionado
        if($.fn.yiiGridView.getSelection(id)!=''){
            $.ajax({
                 type: 'POST',
                 url: "<?php echo CController::createUrl('notaVenta/getNotaVenta') ?>",
                 data:{'notaVentaId':$.fn.yiiGridView.getSelection("nota-venta-grid")},
                 dataType: 'Text',
                 success:function(data){
                     var datos=jQuery.parseJSON(data);
                     $("#notaVentaIds").val($.fn.yiiGridView.getSelection(id));
                     
                     $("#subtotal").val(datos.montoTotal);
                     $("#submitBoton").removeAttr("disabled");
                     Recalcular();
                 }
             });
        } else  {
            $("#subtotal").val(0);
            $("#submitBoton").attr("disabled","disabled");
            Recalcular();
        }
        
    }
    
    function Recalcular(){
                     
                     var iva = (parseFloat($("#subtotal").val())+parseFloat($("#Facturas_recargo").val())-parseFloat($("#Facturas_descuento").val()))*21/100;
                     var total = (parseFloat($("#subtotal").val())+parseFloat($("#Facturas_recargo").val())-parseFloat($("#Facturas_descuento").val())+iva);
                     if(tipoDocumento=='FAC_A') {
                         $("#iva").val(iva.toFixed(2));
                     }
                     $("#Facturas_montoTotal").val(total.toFixed(2));
    }
    
    function VerificarMascara(obj)
    {
        var valor=$(obj).val().replace( "_", "0");
        valor=valor.replace( "_", "0");
        $(obj).val(valor);
    }
    
    </script>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'facturas-form',
	'enableAjaxValidation'=>false,
)); ?>
    <?php echo $form->errorSummary($model); ?>
    <table>
        <tbody>
            <tr>
                <td>
                       <span style="font-weight:bold">Tipo Factura <span class="required">*</span></span> 
                        <?php echo $form->textField($model,'tipoFactura',array('value'=>$documento->tipoDocumento,'size'=>5,'maxlength'=>1,'readonly'=>'readonly')); ?>
                </td>
                <td></td>
            </tr>
            <tr>
                <td>                 
                        <span style="font-weight:bold">Fecha <span class="required">*</span></span> 
                        <?php echo $form->textField($model,'fecha',array('size'=>15,'maxlength'=>15, 'value'=>Date("d/m/Y"),'readonly'=>'readonly' ));
                        
                        ?>
                </td>
                <td colspan="2">
                        <span style="font-weight:bold">Numero <span class="required">*</span></span>
                        <?php echo $form->textField($model,'puntoVenta',array("size"=>5,"value"=>str_pad(($documento->sucursal),'4',"0", STR_PAD_LEFT),'readonly'=>'readonly')); ?>
                         - 
                        <?php echo $form->textField($model,'numero',array("value"=>str_pad(($documento->ultimoNumero + 1),'9',"0", STR_PAD_LEFT),'readonly'=>'readonly')); ?>
                </td>
            </tr>
        </tbody>
    </table>
<?php 
$this->beginWidget('zii.widgets.CPortlet', array(
    'title' => 'Datos del Cliente',
    'id' => 'datos-cliente'
));
?>
    <table>
        <tr>
            <td>
                <?php echo $cliente->razonSocial ?>
            </td>
            <td>
               <?php echo $cliente->cuit ?>
            </td>
            
        </tr>
        <tr>
            <td colspan="3">
                 <?php echo $cliente->direccion ?> -  <?php echo $cliente->ciudad->nombre ?>
            </td>
        </tr>
    </table>    

<?php $this->endWidget("datos-cliente"); ?>    
<?php 
$this->beginWidget('zii.widgets.CPortlet', array(
    'title' => 'Notas de venta',
    'id' => 'nota-venta-titulo'
));
?>	

<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'nota-venta-grid',
	'dataProvider'=>$notaVenta->searchImpagas($cliente->id),
	'filter'=>$notaVenta,
        'selectionChanged' => 'CalcularMontoTotal',
        'selectableRows' => -1,
	'columns'=>array(
                 array(
                    'header' => 'Nota Venta seleccionada',
                    'class' => 'CCheckBoxColumn',
                ),
		'id',
		'detalle',
		'fechaVencimiento',
		'periodo',
                array(
			'name'=>'saldo',
			'header'=>'Saldo sin iva',
			'value'=>'$data->getSaldoSinIva()',
		),
	),
)); ?>

<?php $this->endWidget("nota-venta-titulo"); ?>

        <?php echo $form->hiddenField($model, 'clienteId', array('value'=>$cliente->id)) ?>
        <?php echo CHtml::hiddenField('notaVentaIds[]', '', array('id'=>'notaVentaIds')) ?>

	<div class="row">
		<?php echo $form->labelEx($model,'recargo'); ?>
		<?php echo $form->textField($model,'recargo',array('value'=>0,'size'=>15,'maxlength'=>15,'onblur'=>'Recalcular()','class'=>'numeric')); ?>
		<?php echo $form->error($model,'recargo'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'descuento'); ?>
		<?php echo $form->textField($model,'descuento',array('value'=>0,'size'=>15,'maxlength'=>15,'onblur'=>'Recalcular()','class'=>'numeric')); ?>
		<?php echo $form->error($model,'descuento'); ?>
	</div>

            <div class="row">
		<?php echo CHtml::label("Subtotal", "subtotal") ?>
		<?php echo CHtml::textField("subtotal", 0, array("id"=>"subtotal",'readonly'=>'readonly'));  ?>
            </div>
    
        <?php if($documento->tipoDocumento=="FAC_A") { ?>

            <div class="row">
		<?php echo CHtml::label("Iva", "iva") ?>
		<?php echo CHtml::textField("iva", 0, array("id"=>"iva",'readonly'=>'readonly'));  ?>
            </div>
        <?php } ?>
        
	<div class="row">
		<?php echo $form->labelEx($model,'montoTotal'); ?>
		<?php echo $form->textField($model,'montoTotal',array('value'=>0,'size'=>15,'maxlength'=>15, 'readonly'=>'readonly')); ?>
		<?php echo $form->error($model,'montoTotal'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Crear' : 'Save',array('id'=>'submitBoton','disabled'=>'disabled')); ?>
	</div>

<?php $this->endWidget("facturas-form"); ?>

</div><!-- form -->
