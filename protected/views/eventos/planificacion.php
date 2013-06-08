
<h3>Instalaciones Programadas</h3>
<div class="grid-view">
    <table class="items">
        <thead>
            <tr>
                <th>Hora</th>
                <th>Cliente</th>
                <th>Direccion</th>
                <th>Telefono</th>
                <th>Barrio</th>
                <th>Ciudad</th>
                <th>observaciones</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            <?php
            //obtenemos las instalaciones para el dia seleccionado
            $Instalaciones=$model->getInstalaciones($fechaActual);

            foreach ($Instalaciones as $instalacion) {

                $solicitud = Solicitudes::model()->findByPK($instalacion->eventoRelacionadoId);
                echo "<tr><td>" . $instalacion->hora.
                "</td><td>" . $solicitud->razonSocial.
                "</td><td>" . $solicitud->direccion.
                "</td><td>" . $solicitud->telefono .
                "</td><td>" . $solicitud->barrio->nombre .
                "</td><td>" . $solicitud->ciudad->nombre.
                "</td><td>" . $instalacion->observaciones.
                "</td><td>" . CHtml::link('Reprogramar',array('solicitudes/update','id'=>$solicitud->id))." | ".CHtml::link('Cancelar',array('solicitudes/delete','id'=>$solicitud->id)).
                "</td></tr>";

                
            }
            ?>           
        </tbody>
    </table>
</div>    


<h3>Soportes OnSite Programados</h3>