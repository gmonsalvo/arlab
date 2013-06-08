<div class="grid-view">
    <table class="items">
        <thead>
            <tr>
                <th>Fecha/Hora</th>
                <th>Numero Destino</th>
                <th>Duracion</th>
                <th>Tarifa</th>
                <th>Descripcion Tarifa</th>
                <th>Costo</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $costoTotal = 0;
            $cantidadLlamadas = 0;
            $contadorMinutos = 0;
            $contador_minutos_libres = $model->minutosLibres;
            foreach ($llamadas as $llamada) {

                $tarifa = $model->obtenerTarifaLlamada($llamada['dst']);
                if ($tarifa['prefijo'] == '4' or $tarifa['prefijo'] == '0') {
                    $contador_minutos_libres = $contador_minutos_libres - $llamada['duracion_min'];
                    if ($contador_minutos_libres > 0) {
                        $costoLlamada = 0.00;
                    } else {
                        $costoLlamada = $tarifa['precio_venta'] * Yii::app()->params->cotizacionDolar * $llamada['duracion_min'];
                    }
                } else {
                    $costoLlamada = $tarifa['precio_venta'] * Yii::app()->params->cotizacionDolar * $llamada['duracion_min'];
                }
                echo "<tr><td>" . $llamada['calldate'] .
                "</td><td>" . $llamada['dst'] .
                "</td><td>" . $llamada['duracion_min'] .
                "</td><td>" . $tarifa['precio_venta'] * Yii::app()->params->cotizacionDolar .
                "</td><td>" . $tarifa['descripcion'] .
                "</td><td>" . $costoLlamada .
                "</td></tr>";

                $contadorMinutos = $contadorMinutos + $llamada['duracion_min'];
                $costoTotal = $costoTotal + $costoLlamada;
                $cantidadLlamadas++;
            }
            echo "<tr><th colspan=6>Cant. llamadas: " . $cantidadLlamadas . " Minutos Consumidos:" . $contadorMinutos . "  Costo Llamadas Realizadas:" . number_format($costoTotal, 2) . "  IVA:" . number_format($costoTotal * 0.21, 2) . " Costo Total Final:" . number_format($costoTotal * 1.21, 2) . "</td></tr>";
            $image = '<img src=' . Yii::app()->baseUrl . '/images/exportPdf.png  border="0" >';
            $help_file = '<a href=' . Yii::app()->baseUrl . '/index.php/serviciosVoip/exportPdf?periodo=' . $anio . $mes . '&id=' . $model->id . ' target="_blank">';

            echo "<tr><td colspan=6>" . $help_file . ' ' . $image . '</a></td></tr>';
            ?>           
        </tbody>
    </table>
</div>    
