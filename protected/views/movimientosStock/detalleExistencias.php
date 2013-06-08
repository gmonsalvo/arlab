<div class="grid-view">
    <table class="items">
        <thead>
            <tr>
                <th>Equipamiento</th>
                <th>Ingresos</th>
                <th>Salida</th>
                <th>Stock Actual</th>
            </tr>
        </thead>
        <tbody>
            <?php
            //primero contamos la cantidad de registro devueltos
           
         
            foreach ($equipos as $existencia) {
                $ingreso=MovimientosStock::model()->getIngresos($existencia->equipoId,$depositoId);
                $egreso=MovimientosStock::model()->getEgresos($existencia->equipoId,$depositoId);        
                $saldo = $ingreso - $egreso;
                echo "<tr><td align=center>" . $existencia->equipo->descripcion .
                "</td><td align=center>" . $ingreso .
                "</td><td align=center>" . $egreso .
                "</td><td align=center>" . $saldo .
                "</td></tr>";
              
              
            } // fin del for
            ?>           
        </tbody>
    </table>
</div>    
